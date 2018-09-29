<?php
declare(strict_types=1);

/**
 * Administration controller. Handles the administration of the application.
 * 
 * The trait Objectify allows this class to be instantiated, and calls to the
 * objects private methods is allowed. This enables this class to be used as a
 * library elsewhere.
 * 
 * @see Objectify
 * 
 * @package mna
 * @subpackage controllers
 * 
 * @author Tom Andre Munkhaug <me@tombayo.com>
 * 
 */
class admin extends Controller {
  use Objectify;
  
  /**
   * @var array Manually set options for password_hash()
   */
  private static $pwsettings = ['cost' => 9];
  
  /**
   * Contains all accessible methods in this controller, and their required
   * accesslevel.
   * 
   * Say if a user wants to access filemanager, this array specifies the
   * minimum accesslevel the user must have.
   * 
   * @var array
   */
  private static $menuaccess = ['index'       => 5,
                                'editpw'      => 1,
                                'edituser'    => 1,
                                'editpersons' => 6,
                                'members'     => 5,
                                'vote'        => 5,
                                'votestatus'  => 6,
                                'benchpw'     => 9,
                                'genpw'       => 9,
                                'testmail'    => 9,
                                'php'         => 9
                                ];
  /**
   * Generates an array of menu-items based on the supplied accesslevel.
   * 
   * The array is populated based on the controller's $menu property, and
   * filtered based on each method's accesslevel specified in the controller's
   * $menuaccess property.
   * @see admin::$menu, admin::$menuaccess 
   * 
   * @param int $accesslvl
   * @return array
   */
  private static function generateMenu(int $accesslvl=5, $i18n):array {
    
      /**
       * Specifies each item in the admin-menu with controller-name => UI-text.
       * A submenu can be specified by UI-text => array(controller-name => UI-text).
       * @var array
       */
      $menu = [ 'index'=>$i18n->dict->adminnav->index,
                'members'=>$i18n->dict->adminnav->members,
                'editpersons'=>$i18n->dict->adminnav->editpersons,
                'vote'=>$i18n->dict->adminnav->vote.'(Test)',
                'votestatus'=>$i18n->dict->adminnav->votestatus,
                'Developer Tools:'=>[
                  'benchpw'=>'PW Bench',
                  'genpw'=>'PW Gen',
                  'testmail'=>'Test Mail',
                  'php'=>'PHPinfo']
              ];
              
    foreach ($menu as $key => $value) {
      if (is_array($value)) {
        foreach ($value as $subkey => $subvalue) {
          if (self::$menuaccess[$subkey] <= $accesslvl) {
            $newmenu[$key][$subkey] = $subvalue;
          }
        }
      } else {
        if (self::$menuaccess[$key] <= $accesslvl) {
          $newmenu[$key] = $value;
        }
      }
    }
    return $newmenu;
  }
  /**
   * Creates a basic template preset with the most common settings used
   * in the admin-controller, and returns the View without rendering it. 
   * 
   * It checks if the user is logged inn with high enough privileges,
   * loads a view based on the caller method, sets common settings, and
   * returns the View.
   * If the user isn't logged in, or lacks privileges, the user is redirected
   * to this controllers index.
   * The methods privileges are checked by looking in $menuaccess:
   * @see admin::$menuaccess
   * 
   * @global $config Used for passing settings to the view.
   * 
   * @return View
   */
  private static function basicAdminTemplate():View {
    // Lets find out who called us :)
    $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS,2)[1]['function'];
    if (self::isLoggedIn(self::$menuaccess[$caller] ?? 9)) {
      global $config;
      $i18n = new i18nHelper($_SESSION['language'] ?? $config['language']);
      
      $template = Load::view('view.admin.'.$caller);
      $template->set('controller', __CLASS__);
      $template->set('page', $caller);
      $template->set('lang', $i18n);
      $template->set('menu', self::generateMenu($_SESSION['accesslevel'],$i18n));
      $template->set('url', function ($controller,$method='',$get=[],$frag='') {
        return parent::createUrl($controller,$method,$get,$frag);
      });
      $template->set('user', self::getUser($_SESSION['user'])->export());
    } else {
      parent::redirect('admin');
    }
    
    // Empty view is returned when user is redirected, this is to avoid any errors.
    return $template ?? new View('view.empty');
  }
  /**
   * This controller's main method. Checks if user is logged in.
   * If so; shows the dashboard. If not; shows the login-screen.
   * 
   * A logged in user with too low privileges will be redirected to base url.
   */
  public static function index() {
    if (self::isLoggedIn(self::$menuaccess[__FUNCTION__])) {
      self::viewDashboard();
    } elseif (self::isLoggedIn(1)) {
      parent::redirect('');
    } else {
      self::viewLogin();
    }
  }
  /**
   * Handles the login-request to admin.
   * 
   * Finds user and checks if password is correct. Rehashes password if needed,
   * or sends an error-message to our user if the information is wrong.
   * User is logged in when $_SESSION['user'] is set with the user ID, and
   * $_SESSION['accesslevel'] is set with the user's accesslevel.
   * 
   */
  public static function login() {
    if (isset($_SESSION['user']) || !isset($_POST['email'])) {
      parent::redirect('');
    } else {
      global $config;
      $i18n = new i18nHelper($_SESSION['language'] ?? $config['language']);
      $tb = Model::initDB();
      $f = new RedBeanPHP\Finder($tb);
      $user = $f->findOne('person',' email = ? ',[$_POST['email']]);
      if ($user) {
        if (password_verify($_POST['password'], $user->password)) {
          if (password_needs_rehash($user->password, PASSWORD_DEFAULT)) {
            // Password needs rehashing
            $user->password = self::hashPassword($_POST['password']);
            $tb->getRedBean()->store($user);
          }
          // Email and password checks out, now logged in
          $_SESSION['user'] = intval($user->id);
          $_SESSION['accesslevel'] = intval($user->accesslevel);
          parent::redirect('admin');
        } else {
          // Password is wrong
          self::viewLogin($i18n->dict->adminerrorlogin->errorcreds,$_POST['email']);
        }
      } else {
        // Email not found
        self::viewLogin($i18n->dict->adminerrorlogin->errorcreds);
      }
    }
  }
  /**
   * Logs the user out, destroying session-data and cookie.
   */
  public static function logout() {
    // Logs the user out, destroys all session data, AND removes the cookie
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    parent::redirect('');
  }
  /**
   * Allows the users to reset their passwords by getting a newly generated
   * password sent to their email.
   */
  public static function resetpw() {
    global $config;
    $i18n = new i18nHelper($_SESSION['language'] ?? $config['language']);

    if ($_POST['email'] ?? false) {
      $tb = Model::initDB();
      $f = new RedBeanPHP\Finder($tb);
      $user = $f->findOne('person',' email = ? ',[$_POST['email']]);
      if ($user) {
        if (self::makeUserRandomPassword(intval($user->id))) {
          self::viewLogin($i18n->dict->adminerrorresetpw->success,$_POST['email']);
        } else {
          self::viewLogin($i18n->dict->adminerrorresetpw->errorgenerate, $_POST['email']);
        }
      } else {
        self::viewLogin($i18n->dict->adminerrorresetpw->emailnoexist);
      }
    } else {
      $template = Load::view('form.panel.resetpw');
      $template->set('page', 'admin.resetpw');
      $template->set('lang', $i18n);
      $template->render(); 
    }
  }
  /**
   * A developer tool for generating hashed passwords in the front-end.
   * Usage: Just go to "admin/genpw?pw=secret" to generate a hash of "secret".
   * @see admin::hashPassword()
   * 
   * @param string $pw
   */
  public static function genpw() {
    if (self::isLoggedIn(self::$menuaccess[__FUNCTION__])) {
      echo self::hashPassword($_GET['pw'] ?? '');
    } else {
      parent::redirect('');
    }
  }
  /**
   * A developer tool for password_hash benchmarking.
   * 
   * This code will benchmark your server to determine how high of a cost you can
   * afford. You want to set the highest cost that you can without slowing down
   * you server too much. 8-10 is a good baseline, and more is good if your servers
   * are fast enough. The code below aims for ≤ 50 milliseconds stretching time,
   * which is a good baseline for systems handling interactive logins.
   * 
   * This code is supplied in the PHP manual, see the link below.
   * 
   * @link http://php.net/manual/en/function.password-hash.php
   */
  public static function benchpw() {
    if (self::isLoggedIn(self::$menuaccess[__FUNCTION__])) {
      $timeTarget = 0.05; // 50 milliseconds
      
      $cost = 8;
      do {
        $cost++;
        $start = microtime(true);
        password_hash("test", PASSWORD_BCRYPT, self::$pwsettings);
        $end = microtime(true);
      } while (($end - $start) < $timeTarget);
      
      echo "Appropriate Cost Found: " . $cost . "\n";
    } else {
      parent::redirect('');
    }
  }
  /**
   * A developer tool for displaying phpinfo()
   */
  public static function php() {
    if (self::isLoggedIn(self::$menuaccess[__FUNCTION__])) {
      phpinfo();
    } else {
      parent::redirect('');
    }
  }
  /**
   * A developer tool for testing the mail function.
   */
  public static function testmail() {
    if (self::isLoggedIn(self::$menuaccess[__FUNCTION__])) {
      $to = $_GET['to'] ?? 'test@tombayo.com';
      $subject = 'Test';
      $content = "
        <!DOCTYPE html>
        <html>
          <head>
            <meta charset=\"utf-8\">
            <title>$subject</title>
          </head>
          <body>
            <h1>Test!</h1>
          </body>
        </html>";
      $headers   = [];
      $headers[] = 'MIME-Version: 1.0';
      $headers[] = 'Content-type: text/html; charset=utf-8';
      $headers[] = 'From: "Midt-Norge Airsoft" <ikkesvar@midtnorgeairsoft.no>';
      $headers[] = 'Subject: '.$subject;
      try {
        $sent = mail($to, $subject, $content, implode("\r\n", $headers));
        if (!$sent) throw new Exception('mail() returned false.');
        echo "Mail sendt to: ".$to;
      } catch (Throwable $e) {
        echo "Something went wrong: <br>\n";
        echo $e->getMessage();
        echo "<br>\n";
        echo "To: ".$to."<br>\n";
        echo "Subject: ".$subject."<br>\n";
        echo "Content: ".htmlentities($content)."<br>\n";
        echo "Headers: ".htmlentities(implode("\r\n", $headers));
      }
    } else {
      parent::redirect('');
    }
  }
  /**
   * Renders a view to allow logged in users to change their passwords.
   * Also handles the form-data POSTed from this view.
   * 
   * @see view.admin.editpw.php
   */
  public static function editpw() {
    $template = self::basicAdminTemplate();
    $i18n = $template->get('lang');
      
    if (isset($_POST['submit'])) {
      Load::plugin('php-val/validator');
      $v = new Validator($_POST);
      $requiredtxt = '%s: '.$i18n->dict->admineditpw->valrequired;
      
      $v->required($requiredtxt)->validate('oldpw',false,$i18n->dict->adminusercontrols->currentpw);
      $v->required($requiredtxt)->matches('newpw2', $i18n->dict->adminusercontrols->repeatnewpw, '%s: '.$i18n->dict->admineditpw->valpwnotequals)
        ->validate('newpw',false,'Nytt Passord');
      if (!$v->hasErrors()) {
        $tb = Model::initDB();
        $rb = $tb->getRedBean();
        $user = $rb->load('person',$_SESSION['user']);
        if (password_verify($_POST['oldpw'], $user->password)) {
          $user->password = self::hashPassword($_POST['newpw']);
          $rb->store($user);
          $template->set('success', $i18n->dict->admineditpw->success);
        } else {
          $template->set('errors', [$i18n->dict->adminusercontrols->currentpw => $i18n->dict->admineditpw->errorpw]);
        }
      } else {
        $template->set('errors', $v->getAllErrors());
      }
    }
    $template->render();
  }
  /**
   * Renders a view to allow logged in users to edit their personal information.
   * Also handles the form-data POSTed from this view.
   * 
   * @see view.admin.edituser.php
   */
  public static function edituser() {
    $template = self::basicAdminTemplate();
    $i18n = $template->get('lang');

    if (isset($_POST['submit'])) {
      // validate, and make changes
      $_POST = array_map('admin::strfix', $_POST);
      $val = self::validateFields($_POST);
      if (!$val->hasErrors()) {
        self::updateUser($_SESSION['user'], $_POST, true);
        $template->set('formdata',self::getUser($_SESSION['user'])->export());
        $template->set('success', $i18n->dict->adminedituser->success);
      } else {
        $template->set('formdata', $_POST);
        $template->set('errors', $val->getAllErrors());
      }
    } else {
      // show current info + form
      $template->set('formdata',self::getUser($_SESSION['user'])->export());
    }
    $template->render();
  }
  /**
   * Renders a view to allow users to search for persons in the database,
   * and to change their accesslevels. Also allows for manually adding users
   * to the database.
   * 
   * @see view.admin.persons.php
   * 
   */
  public static function editpersons() {
    $template = self::basicAdminTemplate();
    $template->set('accessgroups', self::getAccessGroups());
    $i18n = $template->get('lang');
    if ($_POST ?? false) {
      $post = array_map('admin::strfix', $_POST);
      $val = self::validateFields($post);
      try {
        if ($val->hasErrors()) throw new Exception('Formerror',1);
        $user = self::findUser($post['email']);
        if ($user) throw new Exception($i18->dict->admineditpersons->erroruserexists);
        $user = self::newUser($post);
        if (!$user) throw new Exception($i18->dict->admineditpersons->errorusergen);
        $template->set('success',$i18n->dict->admineditpersons->success);
      } catch(Catchable $e) {
        $template->set('error', $e->getMessage());
      } finally {
        $template->render();
      }
    } else {
      $userid = $_GET['userid'] ?? false;
      $accesslvl = $_GET['accesslvl'] ?? false;
      if ($userid && $accesslvl) {
        $userid = intval($userid);
        $accesslvl = intval($accesslvl);
        $user = self::getUser($userid);
        try {
          if (!($user->id ?? false)) throw new Exception($i18n->dict->admineditpersons->errornouser);
          if ($accesslvl == 9) throw new Exception($i18n->dict->admineditpersons->errorinvalidaccessgrp);
          if (!self::setUserAccessGroup($userid, $accesslvl)) throw new Exception($i18n->dict->admineditpersons->erroraccessgrperror);
          if (!$user->password) self::makeUserRandomPassword($userid);
          $template->set('success', $i18n->dict->admineditpersons->accessgrpsuccess);
        } catch(Throwable $e) {
          $template->set('error', $e->getMessage());
        }
      }
      $template->render();
    }
  }
  /**
   * Handles the search-queries from the front-end, and replies in JSON.
   * 
   * Allows to search by firstname, lastname or accessgroup.
   * Does a database search for the selected column. If nothing is found,
   * the response is just the JSON-object 'empty', otherwise the returned array
   * from database is encoded to JSON and printed out.
   * 
   * @see admin::editpersons(), view.admin.editpersons.php
   * 
   */
  public static function jsonpersons() {
    if (self::isLoggedIn(self::$menuaccess['editpersons'] ?? 9)) {
      $stype = $_GET['type'] ?? false;
      $stext = $_GET['text'] ?? false;
      if ($stype && $stext) {
        
        header("Content-Type: application/json; charset=UTF-8");
        
        try {
          $tb = Model::initDB();
          $a = $tb->getDatabaseAdapter();
          
          // ----- BE CAREFUL WHEN EDITING BELOW ----- \\
          // Next lines are currently safe, but be very careful when modifying them!
          // High risk of SQL injection because of a case of avoiding sql-bindings
          
          if ($stype === 'firstname') {
            $dynsql = 'p.firstname';
          } elseif ($stype === 'lastname') {
            $dynsql = 'p.lastname';
          } elseif ($stype === 'accessgroup') {
            $dynsql = 'ag.groupname';
          } else {
            throw new Exception('Unrecognized search-type.');
          }
          $r = $a->get('SELECT  p.id, p.firstname, p.lastname, p.email, p.accesslevel, ag.groupname
                        FROM person p, accessgroup ag
                        WHERE p.accesslevel=ag.id
                        AND '.$dynsql.' LIKE ?
                        ORDER BY p.lastname, p.firstname',['%'.$stext.'%']);

          // ----- END OF POTENTIALLY DANGEROUS CODE ----- \\
          
          if ($r[0]['id'] ?? false) {
            echo json_encode($r);
          } else {
            echo json_encode(['empty'=>'true']);
          }
        } catch(Throwable $e) {
          echo json_encode(['error'=>['msg'=>$e->getMessage()]]);
        }
      } else {
        echo json_encode(['error'=>['msg'=>'Inputerror']]);
      }
    } else {
      echo json_encode(['error'=>['msg'=>'Access Denied!']]);
    }
  }
  /**
   * Renders a view containing the list of current members in the database.
   * 
   * @see view.admin.members.php
   */
  public static function members() {
    $template = self::basicAdminTemplate();
    $tb = Model::initDB();
    $a = $tb->getDatabaseAdapter();
    $r = $a->get('SELECT p.firstname, p.lastname, p.email, ag.groupname
                  FROM person p, accessgroup ag
                  WHERE p.accesslevel=ag.id
                  ORDER BY p.firstname');
    
    $template->set('dbdata',$r);
    
    $template->render();
  }
  /**
   * Renders a view for voting
   */
  public static function vote() {
    $required_accesslvl = self::$menuaccess['vote'];
    $db_voterid         = 'votetest1voterid';
    $db_votes           = 'votetest1votes';
    $db_candidates      = 'votetest1candidates';

    $template = self::basicAdminTemplate();
    $tb = Model::initDB();
    $a = $tb->getDatabaseAdapter();

    $userid = $_SESSION['user'];
    $i18n = $template->get('lang');

    $uservoted = $a->get('SELECT id FROM '.$db_voterid.' WHERE id = ?',[$userid]);
    $candidates = $a->get('SELECT p.id,p.firstname,p.lastname
                           FROM person p, '.$db_candidates.' c
                           WHERE c.id=p.id');
    try {
      // check if user already has voted:
      if ($uservoted) throw new Exception($i18n->dict->adminvote->alreadyvoted);
      
      // Check if form is submitted (not really an error if not):
      if (!isset($_POST['submit'])) throw new Exception('Not submitted, non-error',2); 
      
      // check if a candidate has been chosen before submit:
      if (!$_POST['vote']) throw new Exception($i18n->dict->adminvote->choosecandidate,1);

      // check if candidate exists in db:
      $candidateIDs = [];
      foreach ($candidates as $candidate) {
        $candidateIDs[] = $candidate['id'];
      }
      if (!in_array($_POST['vote'], $candidateIDs)) throw new Exception($i18n->dict->adminvote->invalidcandidate,1);
      
      // check if user has high enough accesslevel:
      if ($_SESSION['accesslevel'] < $required_accesslvl) throw new Exception($i18n->dict->adminvote->noaccess);

      // generate random key:
      $rnd_key = bin2hex(openssl_random_pseudo_bytes(32));

      // add hash of random key and user ID to voteleader2018voterid:
      $hash = self::hashPassword($rnd_key);
      $a->exec('INSERT INTO '.$db_voterid.'
                (id, hash) VALUES(
                :id, :hash
                );', ['id'=>$userid,'hash'=>$hash]);

      // encrypt voter id with key above and store with candidate id in voteleader2018votes:
      $cipher = "aes-256-cbc";
      /**
       * A comment to the following line of code:
       * Intentionally using a non-random iv when encrypting to produce the same
       * ciphertext when the same key and plaintext is used. This is to prevent duplicate
       * votes in the database, as the database is configured to only allow unique entries
       * in the "cryptid" column.
       */
      $crypt_voterid = openssl_encrypt(''.$userid, $cipher, $rnd_key,0,'a non-random iv ');
      $a->exec('INSERT INTO '.$db_votes.'
                (cryptid, candidateid) VALUES(
                :id, :candidate
                );', ['id'=>$crypt_voterid,'candidate'=>$_POST['vote']]);
      
      // present user with key and success-message.
      $template->set('voterkey', $rnd_key);

    } catch (Throwable $e) {
      if (($e->getCode() == 1)||($e->getCode() == 2)) $template->set('candidates',$candidates);
      if ($e->getCode() != 2) $template->set('errors', $e);
    }
    $template->render();
  }
  /**
   * Renders a view showing votingstatus.
   */
  public static function votestatus() {
    $db_voterid         = 'votetest1voterid';
    $db_votes           = 'votetest1votes';
    $db_candidates      = 'votetest1candidates';

    $template = self::basicAdminTemplate();
    $tb = Model::initDB();
    $a = $tb->getDatabaseAdapter();
    
    $votes = $a->get('SELECT * FROM '.$db_votes);
    $voters = $a->get('SELECT * FROM '.$db_voterid);
    $votespercandidate = $a->get('
      SELECT CONCAT_WS(\' \', p.firstname, p.lastname) AS name, COUNT(*) AS votes
      FROM person p, votetest1votes v
      WHERE p.id = v.candidateid
      GROUP BY v.candidateid');

    $numvotes = count($votes);
    $numvoters = count($voters);

    $template->set('numvotes',$numvotes);
    $template->set('numvoters',$numvoters);
    $template->set('votespercandidate',$votespercandidate);
    
    $template->render();
  }
  /**
   * Renders the Dashboard.
   * @see view.admin.dash.php
   * 
   * @todo can basicAdminTemplate() be used here?
   * 
   * @param string $feedback
   */
  private static function viewDashboard(string $feedback='') {
    global $config;
    $i18n = new i18nHelper($_SESSION['language'] ?? $config['language']);
    
    $template = Load::view('view.admin.dash');
    $template->set('controller', __CLASS__);
    $template->set('page', 'index');
    $template->set('lang', $i18n);
    $template->set('menu', self::generateMenu($_SESSION['accesslevel'],$i18n));
    $template->set('feedback', $feedback);
    $template->set('user', self::getUser($_SESSION['user'])->export());
    $template->set('url', function ($controller,$method='',$get=[],$frag='') {
      return parent::createUrl($controller,$method,$get,$frag);
    });
    $template->render();
  }
  /**
   * Renders the login-page.
   * The method login() handles the login-request.
   * @see view.admin.login.php, admin::login()
   * 
   * @param string $errormsg
   */
  private static function viewLogin(string $errormsg='', string $email='') {
    global $config;
    $template = Load::view('view.admin.login');
    $template->set('controller', __CLASS__);
    $template->set('page', 'login');
    $template->set('lang', new i18nHelper($_SESSION['language'] ?? $config['language']));
    $template->set('url', function ($controller,$method='',$get=[],$frag='') {
      return parent::createUrl($controller,$method,$get,$frag);
    });
    $template->set('email',$email);
    $template->set('errormsg', $errormsg);
    $template->render();
  }
  /**
   * Checks if the user is logged in and has the privileges needed.
   * 
   * Will also update $_SESSION['accesslevel'].
   * If a user's seasonpass has expired, the user's accesslevel is downgraded.
   * 
   * @param int $lvl Minimum accesslevel required.
   * @return bool
   */
  private static function isLoggedIn(int $lvl=5):bool {
    $user = $_SESSION['user'] ?? false;

    if ($user) {
      // Refresh the session-variable in case DB has changed
      $_SESSION['accesslevel'] = intval(self::getUser($user)->accesslevel);
    }
    
    $access = $_SESSION['accesslevel'] ?? 0;
    
    if($user && ($access >= $lvl)) {
      return true;
    } else {
      return false;
    }
  }
  /**
   * Returns a user's database-entry, which may be modified and saved.
   * 
   * @param int $id
   * @return RedBeanPHP\OODBBean
   */
  private static function getUser(int $id):RedBeanPHP\OODBBean {
    $tb = Model::initDB();
    $rb = $tb->getRedBean();
    $user = $rb->load('person',$id);
    return $user;
  }
  /**
   * Looks for an existing user based on email.
   * 
   * @param string $email
   * @return int $userid, 0 if not found
   */
  private static function findUser(string $email):int {
    $tb = Model::initDB();
    $a = $tb->getDatabaseAdapter();
    $userid = 0;
    $response = $a->get('SELECT id, email FROM person WHERE email=?',[$email]);
    foreach($response as $row) {
      if ($userid) {
        global $config;
        $err = Load::controller($config['error_controller']);
        $err->logerror(New Exception('Duplicate users in DB; '.$email.' - '.$tlf));
      } elseif ($row['email'] == $email) {
        $userid = $row['id'];
      }
    }
    return intval($userid);
  }
  /**
   * Creates a password using settings in $pwsettings.
   * @see admin::$pwsettings
   * 
   * @param string $password
   * @return string password-hash
   */
  private static function hashPassword(string $password):string {
    return password_hash($password, PASSWORD_DEFAULT, self::$pwsettings);
  }
  /**
   * Generates a random password for the supplied user. Also sends the new
   * password to the user's email-address.
   * 
   * @param int $userid
   * @return bool
   */
  private static function makeUserRandomPassword(int $userid):bool {
    $tb = Model::initDB();
    $rb = $tb->getRedBean();
    $user = $rb->load('person',$userid);
    if ($user) {
      $rndstring = substr(md5(strval(rand())),0,8);
      $user->password = self::hashPassword($rndstring);
      if ($rb->store($user)) {
        global $config;
        $email = Load::view('email.password.generated');
        $email->set('temppw',$rndstring);
        $email->set('user',$user->export());
        $i18n = $email->set('lang',new i18nHelper($_SESSION['language'] ?? $config['language']));
        $content = $email->render(true);
        $headers   = [];
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8';
        $headers[] = 'From: "Midt-Norge Airsoft" <ikkesvar@midtnorgeairsoft.no>';
        $headers[] = 'Subject: '.$i18n->dict->adminpwmail->subject;
        $to = '"'.ucwords($user->firstname).' '.ucwords($user->lastname).'" <'.$user->email.'>';
        try {
          $sent = mail($to, $i18n->dict->adminpwmail->subject, $content, implode("\r\n", $headers));
          if (!$sent) throw new Exception();
          return true;
        } catch (Throwable $e) {
          return false;
        }
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
  /**
   * Lowers all characters, and handles HTML special characters like < and >
   *
   * @param string $str
   * @return string
   */
  private static function strfix(string $str):string {
    return htmlspecialchars(strtolower($str),ENT_QUOTES,'UTF-8');
  }
  /**
   * Validates the common input-fields used throughout the application.
   *
   * @param array $post
   * @return Validator
   */
  private static function validateFields(array $post):Validator {
    load::plugin("php-val/validator");
    $v = new Validator($post);
    $requiredtxt = '%s: Feltet må fylles ut.';
    $v->required($requiredtxt)
    ->maxlength(64,'%s: Feltet er for langt.')
    ->validate('firstname',false,'Fornavn');
    $v->required($requiredtxt)
    ->maxlength(64, '%s: Feltet er for langt.')
    ->validate('lastname',false,'Etternavn');
    $v->required($requiredtxt)
    ->email('%s: Feltet må være en gylding epost-adresse.')
    ->validate('email',false,'Epost');
    return $v;
  }
  /**
   * Updates the database with updated user info, unless the user has a password
   * registered to the account.
   * Setting $forceFullUpdate to true ignores the password-check.
   *
   * Also bumps the users accesslevel to 1 if its 0.
   *
   * @param int $userid
   * @param array $post
   * @param bool $forceFullUpdate
   * @return int
   */
  private static function updateUser(int $userid, array $post, bool $forceFullUpdate = false):int {
    $tb = Model::initDB();
    $rb = $tb->getRedBean();
    $user = $rb->load('person',$userid);
    if (is_null($user->password) || $forceFullUpdate) {
      $user->firstname = $post['firstname'];
      $user->lastname = $post['lastname'];
    }
    if ($forceFullUpdate) {
      $user->email = $post['email'];
    }
    if ($user->accesslevel == 0) {
      $user->accesslevel = 1;
    }
    return $rb->store($user);
  }
    /**
   * Creates a new user based on supplied post-data.
   * 
   * Assumes post-data has been validated.
   * 
   * @param array $post
   * @return int
   */
  private static function newUser(array $post):int {
    $tb = Model::initDB();
    $rb = $tb->getRedBean();
    $user = $rb->dispense('person');
    $user->firstname = $post['firstname'];
    $user->lastname = $post['lastname'];
    $user->email = $post['email'];
    $user->accesslevel = 1;
    return $rb->store($user);
  }
  /**
   * Returns the application's accessgroups.
   * 
   * @return array
   */
  private static function getAccessGroups():array {
    $tb = Model::initDB();
    $a = $tb->getDatabaseAdapter();
    return $a->get('SELECT * FROM accessgroup');
  }
    /**
   * Sets a user's accesslevel.
   * 
   * Changes cannot be made to an administrator's accesslevel(=9).
   * 
   * @param int $userid
   * @param int $accesslevel
   * @return bool
   */
  private static function setUserAccessGroup(int $userid, int $accesslevel):bool {
    try {
      $tb = Model::initDB();
      $rb = $tb->getRedBean();
      $user = $rb->load('person',$userid);
      if (!$user) throw new Exception;
      if ($user->accesslevel == 9) throw new Exception;
      $user->accesslevel = $accesslevel;
      if (!$rb->store($user)) throw new Exception;
      return true;
    } catch(Throwable $e) {
      return false;
    }
  }
}