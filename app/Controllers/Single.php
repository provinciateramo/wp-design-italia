<?php
/**
 * Created by PhpStorm.
 * User: gianluca
 * Date: 17/01/19
 * Time: 21.59
 * PHP Version 5.6
 *
 * @package app\Controllers
 */

namespace app\Controllers;

use Sober\Controller\Controller;
use function App\asset_path;
use function App\template;


global $social_links_def;

/**
 * Class Single
 *
 * @package AppControllers
 */
class Single extends Controller {

	/**
	 * Declare implementing tree.
	 *
	 * @var bool
	 */
	protected $tree = true;

}
