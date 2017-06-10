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
  private static $menuaccess = ['index'   => 5,
                                'editpw'  => 1,
                                'edituser'=> 1,
                                'members' => 5,
                                'benchpw' => 9,
                                'genpw'   => 9,
                                'php'     => 9
                                ];
  /**
   * Specifies each item in the admin-menu with controller-name => UI-text.
   * A submenu can be specified by UI-text => array(controller-name => UI-text).
   * @var array
   */
  private static $menu = ['index'=>'Hjem',
                          'members'=>'Medlemmer',
                          'Utvikler-verktøy'=>[
                            'benchpw'=>'PW Bench',
                            'genpw'=>'PW Gen',
                            'php'=>'PHPinfo']
                          ];
  /**
   * @var string Full filepath to the shared files folder.
   */
  private static $sharefolder = ROOT_DIR.'share/';
  
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
  private static function generateMenu(int $accesslvl=5):array {
    $menu = [];
    foreach (self::$menu as $key => $value) {
      if (is_array($value)) {
        foreach ($value as $subkey => $subvalue) {
          if (self::$menuaccess[$subkey] <= $accesslvl) {
            $menu[$key][$subkey] = $subvalue;
          }
        }
      } else {
        if (self::$menuaccess[$key] <= $accesslvl) {
          $menu[$key] = $value;
        }
      }
    }
    return $menu;
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
      $template->set('lang', $i18n);
      $template->set('menu', self::generateMenu($_SESSION['accesslevel']));
      $template->set('url', function ($controller,$method='',$argument='',$get=[],$frag='') {
        return parent::createUrl($controller,$method,$argument,$get,$frag);
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
      $tb = Model::initDB();
      $f = new RedBeanPHP\Finder($tb);
      $user = $f->findOne('person',' email = ? ',[$_POST['email']]);
      if ($user) {
        if (password_verify($_POST['password'], $user->password)) {
          if (password_needs_rehash($user->password, PASSWORD_DEFAULT)) {
            // Password needs rehashing
            $user->password = self::createPassword($_POST['password']);
            $tb->getRedBean()->store($user);
          }
          // Email and password checks out, now logged in
          $_SESSION['user'] = intval($user->id);
          $_SESSION['accesslevel'] = intval($user->accesslevel);
          parent::redirect('admin');
        } else {
          // Password is wrong
          self::viewLogin('Feil Epost/Passord',$_POST['email']);
        }
      } else {
        // Email not found
        self::viewLogin('Feil Epost/Passord');
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
    if ($_POST['email'] ?? false) {
      $tb = Model::initDB();
      $f = new RedBeanPHP\Finder($tb);
      $user = $f->findOne('person',' email = ? ',[$_POST['email']]);
      if ($user) {
        if (self::makeUserRandomPassword(intval($user->id))) {
          self::viewLogin('Sjekk e-posten din for nytt passord',$_POST['email']);
        } else {
          self::viewLogin('En feil skjedde med genereringen av nytt passord, prøv igjen.', $_POST['email']);
        }
      } else {
        self::viewLogin('E-posten finnes ikke.');
      }
    } else {
      global $config;
      $template = Load::view('form.panel.resetpw');
      $template->set('page', 'admin.resetpw');
      $template->set('lang', $config['language']);
      $template->render(); 
    }
  }
  
  /**
   * A developer tool for generating hashed passwords in the front-end.
   * Usage: Just go to "admin/genpw?pw=secret" to generate a hash of "secret".
   * @see admin::createPassword()
   * 
   * @param string $pw
   */
  public static function genpw() {
    if (self::isLoggedIn(self::$menuaccess[__FUNCTION__])) {
      echo self::createPassword($_GET['pw'] ?? '');
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
   * Renders a view to allow logged in users to change their passwords.
   * Also handles the form-data POSTed from this view.
   * 
   * @see view.admin.editpw.php
   */
  public static function editpw() {
    $template = self::basicAdminTemplate();
      
    if (isset($_POST['submit'])) {
      Load::plugin('php-val/validator');
      $v = new Validator($_POST);
      $requiredtxt = '%s: Feltet må fylles ut.';
      
      $v->required($requiredtxt)->validate('oldpw',false,'Nåværende Passord');
      $v->required($requiredtxt)->matches('newpw2', 'Gjenta Nytt Passord', '%s: Passordene er ikke like.')
        ->validate('newpw',false,'Nytt Passord');
      if (!$v->hasErrors()) {
        $tb = Model::initDB();
        $rb = $tb->getRedBean();
        $user = $rb->load('person',$_SESSION['user']);
        if (password_verify($_POST['oldpw'], $user->password)) {
          $user->password = self::createPassword($_POST['newpw']);
          $rb->store($user);
          $template->set('success', 'Passordet ble endret!');
        } else {
          $template->set('errors', ['Nåværende Passord'=>'Feil Passord']);
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
      
    if (isset($_POST['submit'])) {
      // validate, and make changes
      $_POST = array_map('admin::strfix', $_POST);
      $val = self::validateFields($_POST);
      if (!$val->hasErrors()) {
        self::updateUser($_SESSION['user'], $_POST, true);
        $template->set('formdata',self::getUser($_SESSION['user'])->export());
        $template->set('success', 'Informasjonen ble endret!');
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
   * Loads files from $sharefolder and allows users to rename or delete these
   * files, aswell as uploading new files to the folder.
   * 
   * This method handles both the uploading of new files, and renaming/deleting
   * of existing files. Avoids duplicate names by adding a "1." to the front of
   * the filenames. Deleted files wont actually get deleted, they're only moved
   * to "deleted/".
   * 
   * @see admin::$sharefolder, view.admin.filemanager.php
   */
  public static function filemanager() {
    $template = self::basicAdminTemplate();
    $template->set('maxfilesize', ['int'=>(int)(ini_get('upload_max_filesize'))*1000000,
                                   'txt'=>self::humanFilesize((int)(ini_get('upload_max_filesize'))*1000000)]);
    
    if ($_FILES['inputfile']['name'] ?? false) {
      
      // A file has been uploaded
      
      $destination = self::$sharefolder.basename($_FILES['inputfile']['name']);
      $i = 0;
      while (is_file($destination)) {
        $i++;
        $destination = self::$sharefolder.$i.'.'.basename($_FILES['inputfile']['name']);
      }
      if (move_uploaded_file($_FILES['inputfile']['tmp_name'], $destination)) {
        $uploadedPathinfo = pathinfo($destination);
        if (!in_array($uploadedPathinfo['extension'],['php','cgi','py','pl','js','html','shtml'])) {
          $template->set('success', 'Filen &quot;'.$uploadedPathinfo['filename'].'&quot; ble lastet opp!');
        } else {
          unlink($destination);
          $template->set('error', 'Ulovlig filtype lastet opp. Filen ble slettet.');
        }
      } else {
        $template->set('error', 'Filen ble ikke lastet opp.');
      }
    } elseif ($_POST['rename'] ?? false) {
      
      // A file has been requested to be renamed
      
      $file = self::findFile($_POST['hash'] ?? '', self::$sharefolder);
      $newname = $_POST['newname'] ?? false;
      if ($file && $newname) {
        $oldfile = pathinfo($file);
        $newname = htmlspecialchars(str_replace(['/','\\'],'',$newname));
        $newpath = self::$sharefolder.$newname.'.'.$oldfile['extension'];
        $i = 0;
        while (is_file($newpath)) {
          $i++;
          $newpath = self::$sharefolder.$i.'.'.$newname.'.'.$oldfile['extension'];
        }
        if(rename($file,$newpath)) {
          $template->set('success','Filen &quot;'.$oldfile['filename'].'&quot; endret navn til &quot;'.$newname.'&quot;!');
        } else {
          $template->set('error', 'Det skjedde en feil med navneskiftet. Vennligst prøv igjen.');
        }
      } else {
        $template->set('error', 'Det skjedde en feil med navneskiftet. Vennligst prøv igjen.');
      }
    } elseif ($_POST['delete'] ?? false) {
      
      // A file has been requested to be deleted
      
      $file = self::findFile($_POST['hash'] ?? '', self::$sharefolder);
      $filepathinfo = pathinfo($file);
      
      if(self::trashFile($filepathinfo['basename'])) {
        $template->set('success','Filen &quot;'.$filepathinfo['filename'].'&quot; ble slettet!');
      } else {
        $template->set('error','Det skjedde en feil med slettingen. Vennligst prøv igjen.');
      }
    }
    
    $template->set('files', self::listfiles(self::$sharefolder));
    $template->render();
  }
  
  
  public static function members() {
    $template = self::basicAdminTemplate();
    $tb = Model::initDB();
    $a = $tb->getDatabaseAdapter();
    $r = $a->get('SELECT firstname, lastname, email, phonenumber
                  FROM person
                  ORDER BY firstname');
    
    $template->set('dbdata',$r);
    
    $template->render();
  }
  
  /**
   * Creates an array of all the files in $folder, with each entry containing
   * detailed info on the file.
   * 
   * @param string $folder
   * @return array
   */
  private static function listfiles(string $folder):array {
    $filenames = scandir($folder);
    $files = [];
    foreach ($filenames as $filename) {
      $thisfile = $folder.$filename;
      if (is_file($thisfile)) {
        $pathinfo = pathinfo($thisfile);
        $file['name'] = $pathinfo['filename'];
        $file['ext'] = $pathinfo['extension'];
        $file['type'] = self::fileExtToType($pathinfo['extension']);
        $file['url'] = BASE_URL.'share/'.$filename;
        $file['size'] = self::humanFilesize(filesize($thisfile));
        $file['mtime'] = filemtime($thisfile);
        $file['hash'] = sha1_file($thisfile);
        $files[] = $file;
      }
    }
    return $files;
  }
  /**
   * Searches for a file in $folder by looking at the supplied $hash.
   * 
   * @param string $hash SHA1-hash of a file.
   * @param string $folder
   * @return string Path to the file if found, empty string if not.
   */
  private static function findFile(string $hash, string $folder):string {
    $files = scandir($folder);
    $found = '';
    foreach ($files as $file) {
      if ($hash == sha1_file($folder.$file)) {
        $found = $folder.$file;
        break;
      }
    }
    return $found;
  }
  
  /**
   * Function to get human readable filesizes.
   * 
   * @see http://php.net/manual/en/function.filesize.php#106569
   * @author rommel@rommelsantor.com
   * @param int $bytes
   * @param int $decimals
   * @return string
   */
  private static function humanFilesize(int $bytes, int $decimals = 2):string {
    $sz = 'BKMGTP';
    $factor = floor((strlen(strval($bytes)) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
  }
  /**
   * Converts a file extension to a string compatible with
   * Font Awesome's File Type Icons.
   * @link http://fontawesome.io/icons/#file-type
   *  
   * @param string $extension
   * @return string
   */
  private static function fileExtToType(string $extension):string {
    switch(strtolower($extension)) {
      case 'pdf':
        return '-pdf';
        break;
      case 'doc':
      case 'docx':
      case 'odt':
        return '-word';
        break;
      case 'xls':
      case 'xlr':
      case 'xlsx':
        return '-excel';
        break;
      case 'ppt':
      case 'pptx':
        return '-powerpoint';
        break;
      case 'png':
      case 'jpg':
      case 'jpeg':
      case 'gif':
      case 'bmp':
        return '-image';
        break;
      case '7z':
      case 'rar':
      case 'gz':
      case 'zip':
        return '-archive';
        break;
      case 'txt':
      case 'rtf':
        return '-text';
        break;
      case 'm4a':
      case 'mp3':
      case 'wav':
      case 'wma':
        return '-audio';
        break;
      case '3gp':
      case 'avi':
      case 'm4v':
      case 'mov':
      case 'mp4':
      case 'mpg':
      case 'wmv':
      case 'mkv':
        return '-video';
        break;
      default:
        return '';
    }
  }
  /**
   * Moves a file to the trashfolder 'deleted/'. Also avoids filename-conflicts
   * by adding '1.' to the beginning of conflicting files.
   * 
   * @param string $filename
   * @return bool
   */
  private static function trashFile(string $filename):bool {
    $newpath = self::$sharefolder.'deleted/'.$filename;
    $i = 0;
    while (is_file($newpath)) {
      $i++;
      $newpath = self::$sharefolder.'deleted/'.$i.'.'.$filename;
    }
    if (copy(self::$sharefolder.$filename, $newpath)) {
      return unlink(self::$sharefolder.$filename);
    } else {
      return false;
    }
    
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
    $template->set('lang', $i18n);
    $template->set('menu', self::generateMenu($_SESSION['accesslevel']));
    $template->set('feedback', $feedback);
    $template->set('user', self::getUser($_SESSION['user'])->export());
    $template->set('url', function ($controller,$method='',$argument='',$get=[],$frag='') {
      return parent::createUrl($controller,$method,$argument,$get,$frag);
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
    $template->set('lang', $i18n);
    $template->set('url', function ($controller,$method='',$argument='',$get=[],$frag='') {
      return parent::createUrl($controller,$method,$argument,$get,$frag);
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
   * Creates a password using settings in $pwsettings.
   * @see admin::$pwsettings
   * 
   * @param string $password
   * @return string password-hash
   */
  private static function createPassword(string $password):string {
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
      $user->password = self::createPassword($rndstring);
      if ($rb->store($user)) {
        $email = Load::view('email.password.generated');
        $email->set('temppw',$rndstring);
        $email->set('user',$user->export());
        $content = $email->render(true);
        $subject = 'Passord midtnorgeairsoft.no';
        $headers   = [];
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=utf-8';
        $headers[] = 'From: "Midt-Norge Airsoft" <ikkesvar@midtnorgeairsoft.no>';
        $headers[] = 'Subject: '.$subject;
        $to = '"'.ucwords($user->firstname).' '.ucwords($user->lastname).'" <'.$user->email.'>';
        try {
          mail($to, $subject, $content, implode("\r\n", $headers));
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
    $v->required($requiredtxt)
    ->validate('address',false,'Adresse');
    $v->required($requiredtxt)
    ->digits('%s: Feltet må være et gyldig postnummer (bare tall).')
    ->minlength(4, '%s: Feltet må være et gyldig postnummer (minst 4 siffer).')
    ->maxlength(4, '%s: Feltet må være et gyldig postnummer (max 4 siffer).')
    ->setRule('validpostcode', function($val){
      return self::checkPostcode($val);
    },'%s: Postnummeret eksisterer ikke.');
    $v->validate('postcode',false,'Postnummer');
    $v->required($requiredtxt)
    ->digits('%s: Feltet må være et gyldig telefonnummer (bare tall).')
    ->minlength(8, '%s: Feltet må være et gyldig telefonnummer (minst 8 siffer).')
    ->maxlength(8, '%s: Feltet må være et gyldig telefonnummer (max 8 siffer).')
    ->validate('phonenumber',false,'Telefonnummer');
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
      $user->address = $post['address'];
      $user->postcode = $post['postcode'];
    }
    if ($forceFullUpdate) {
      $user->email = $post['email'];
      $user->phonenumber = $post['phonenumber'];
    }
    if ($user->accesslevel == 0) {
      $user->accesslevel = 1;
    }
    return $rb->store($user);
  }
  /**
   * Checks the validity of the supplied postcode.
   *
   * @param string $postnr Postcode
   * @return bool
   */
  public static function checkPostcode(string $postcode):bool {
    if (is_numeric($postcode) &&
      $postcode > 0 &&
      $postcode < 9999) {
        $tb = Model::initDB();
        $rb = $tb->getRedBean();
        
        $place = $rb->load('postplace',intval($postcode));
        
        if($place->id ?? false) {
          return true;
        } else {
          return false;
        }
        
      } else {
        return false;
      }
  }
}