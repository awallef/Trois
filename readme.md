Trois ( 3xw )
=====================
version 1.2.1 ( cakePHP 2.x )


MySQL
======================
move plugin/Trois/config/schema/schem.php to
in app/config/schema/schem.php and get all tables you need


LOADING
======================
in app/config/bootstrap.php load file...

<pre><code>
CakePlugin::load('Trois', array('bootstrap' => true,'routes'=>true));
</code></pre>


CHANGE IN YOUR FILES:
======================
1) in app/Controller/AppController.php replace

<pre><code>
App::uses('Controller', 'Controller');
class AppController extends Controller {
</code></pre>

with:

<pre><code>
App::uses('TroisAppController', 'Trois.Controller');
class AppController extends TroisAppController {

public $components = array(
        'Session',
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email')
                )
            ),
            'loginAction' => array(
                'controller' => 'Users',
                'action' => 'login',
                'plugin' => 'trois'
            ),
        ),
        'RequestHandler',
        
    );

</code></pre>

2) in app/Model/AppModel.php  replace

<pre><code>
App::uses('Model', 'Model');
class AppModel extends Model {
</code></pre>

with:

<pre><code>
App::uses('TroisAppModel', 'Trois.Model');
class AppModel extends TroisAppModel {
</code></pre>

3) in core.php un comment line 115 to enable admin route!!

<pre><code>
Configure::write('Routing.prefixes', array('admin'));
</code></pre>

MENU
======================
create menu like so:

<pre><code>
Configure::write('Trois.backendMenu', array(
	
	/** custom **/
        'Voir le site'				=> array('controller'=>'Home','action'=>'index', 'plugin' => false, 'admin' => false),
	
	'Gestion du site'			=>array(		
		'dropdown'			=>array(	
			
			'Types de page'				=> array('controller'=>'Pages','action'=>'index', 'plugin' => false),
			'Contenu des pages'			=> array('controller'=>'PageContents','action'=>'index', 'plugin' => false),
			
			'Categories Sociales'		=> array('controller'=>'SocialCategories','action'=>'index', 'plugin' => false ),
			'Clients'					=> array('controller'=>'Clients','action'=>'index', 'plugin' => false ),
			
			'Contacts'					=> array('controller'=>'Contacts','action'=>'index', 'plugin' => false ),
			
			'Travaux'					=> array('controller'=>'Works','action'=>'index', 'plugin' => false ),
			'Tags'						=> array('controller'=>'Tags','action'=>'index', 'plugin' => false ),
			
			'Banners'					=> array('controller'=>'Banners','action'=>'index', 'plugin' => false ),
		)
	),
	
	
	'News'			=>array(		
		'dropdown'			=>array(	
			
			'Catégories de news'		=> array('controller'=>'NewCategories','action'=>'index', 'plugin' => false),
			'Les news'					=> array('controller'=>'News','action'=>'index', 'plugin' => false),
		)
	),
	
	/** functionalities in Trois plugin boy!!! **/
	'Medias'				=> array(
		
		'dropdown' => array(
			'Bibliothèque'				=> array('controller'=>'Mediafiles', 'action' => 'index', 'admin' => true, 'plugin' => 'trois' ),
			'Téléverser des fichiers'	=> array('controller'=>'Mediafiles', 'action' => 'upload', 'admin' => true, 'plugin' => 'trois' ),
			'Gestion des tags'			=> array('controller'=>'MediaTags', 'action' => 'index', 'admin' => true, 'plugin' => 'trois' ),
		)
	),
	
	'Utilisateurs' => array(
		'dropdown' => array(
			'Utilisateurs'			=> array('controller'=>'Users', 'action' => 'index', 'admin' => true, 'plugin' => 'trois' ),
			'Groupes'				=> array('controller'=>'Groups', 'action' => 'index', 'admin' => true, 'plugin' => 'trois' ),
		)
	)
	
	
	
));
</code></pre>

IPHONE
======================
Add your custom iPhone setting for nice admin web app ; )

<pre><code>
Configure::write('Trois.applicationName','Festitools');
Configure::write('Trois.applicationIconSrc','/img/ft.png');
Configure::write('Trois.applicationSplachIphoneSrc','/img/iPhoneSplach.png');
</code></pre>