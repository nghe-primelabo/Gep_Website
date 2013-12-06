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

//var_dump($this->teachers);exit;

//var_dump($this->teachers);exit;

?>
<div class="candidates-container">
		<ul>

		<?php
			for ($i=0; $i< count($this->teachers['rows']); $i++){
				//var_dump($this->teachers['rows'][$i]);
			?>
            <?php $profileLink = "index.php?option=com_education&view=condetail&layout=teacher&userid=".$this->teachers['rows'][$i]->id;
			?>
				<li class="candidate_list"  title="<?php echo $this->teachers['rows'][$i]->full_name;?>::Đến Từ:<?php echo $this->teachers['rows'][$i]->province;?>">
					<div class="thumnail">
						<a href="<?php echo $profileLink;?>"><img width="205px" height="220px" src="<?php echo $this->teachers['rows'][$i]->avatar;?>" alt="<?php echo $this->teachers['rows'][$i]->full_name;?>" /></a>
					</div>
					<div class="fullname">
							<div class="full_name_text">
								<a href="<?php echo $profileLink;?>">
								<?php
									echo '<span class="full_name">'.$this->teachers['rows'][$i]->full_name.'</span><br/>';
									echo '<span class="line">&nbsp;</span>';
									echo '<span class="views">Views: '.$this->teachers['rows'][$i]->view.'</span>';
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
