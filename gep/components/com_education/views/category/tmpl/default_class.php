<?php
/**
 * @version		01
 * @package		Gep.Site
 * @subpackage	com_education
 * @author Nguyen Xuan Nghe - nxnghe@gmail.com
 * @copyright	Copyright (C) 2013 Prime Labo Technology. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
// Code to support edit links for joomaprosubs
// Create a shortcut for params.

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::core();

$record_per_row = 2;

//var_dump($this->classes);exit;

//var_dump($this->classes);exit;

?>
<div class="candidates-container">
		<ul>

		<?php
			for ($i=0; $i< count($this->classes['rows']); $i++){
				//var_dump($this->classes['rows'][$i]);
			?>
            <?php $profileLink = "index.php?option=com_education&view=condetail&layout=class&classid=".$this->classes['rows'][$i]->id;
			?>
				<li class="candidate_list"  title="<?php echo $this->classes['rows'][$i]->class_name;?>">
					
					<div class="fullname">
							<div class="full_name_text">
								<a href="<?php echo $profileLink;?>">
								<?php
									echo '<span class="full_name">Name: '.$this->classes['rows'][$i]->class_name.'</span><br/>';
									echo '<span class="line">&nbsp;</span>';
									echo '<span class="views">Description: '.$this->classes['rows'][$i]->class_des.'</span>';
								?>
								</a>

							</div>
					</div>
				</li>
				<?php if($i == $record_per_row -1 ){
					?>
					</ul><ul>
					<?php
				}
				?>
			<?php
			}
		?>
		</ul>
	</div>
