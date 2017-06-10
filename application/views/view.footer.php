<?php 
/**
 * Contains the common footer for the webpage.
 *
 * @package mna
 * @subpackage views
 */
?>
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <p class="btn btn-xs btn-block fakebtn">Midt-Norge Airsoft <span class="copy-left">&copy;</span> 2017</p>
          </div>
          <div class="col-sm-4">
            <div class="dropup">
              <a class="btn btn-xs btn-link btn-block" role="button" tabindex="0"
                      data-toggle="popover" data-placement="top" data-trigger="focus"
                      title="<?php echo $lang->dict->footer->cookietitle; ?>" 
                      data-content="<?php echo $lang->dict->footer->cookietxt; ?>">
                <?php echo $lang->dict->footer->cookielink; ?> <span class="caret"></span>
              </a>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="dropup">
              <button class="btn btn-xs btn-link btn-block dropdown-toggle" type="button" id="btn-drop-techdetails"
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $lang->dict->footer->techdetails; ?> <span class="caret"></span>
              </button>
              <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="btn-drop-techdetails">
                <li class="dropdown-header"><?php echo $lang->dict->footer->license; ?>:</li>
                <li><a href="https://www.gnu.org/licenses/gpl.html">GPLv3</a></li>
                <li class="dropdown-header"><?php echo $lang->dict->footer->source; ?>:</li>
                <li><a href="https://github.com/tombayo/midtnorgeairsoft.no"><span class="fa fa-github-alt"></span> GitHub</a>
                <li class="dropdown-header"><?php echo $lang->dict->footer->madeby; ?>:</li>
                <li><a data-email="uW5E_cANduc5hdYmdu">Tom Andre Munkhaug</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
