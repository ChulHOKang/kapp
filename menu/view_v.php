 <?php
		/*
		*   main_image_list.php 에서 콜.
		*/
				$SQL = " SELECT * from {$tkher['tkher_main_img_table']} order by view_no, no";
				if( ($result = sql_query( $SQL ) )==false ){
				  printf("Invalid query: %s ", $SQL);
				  exit();
				} else {
                    $num=0;;
					while( $row = sql_fetch_array($result)  ) {
						$num++;
						$group_name = $row['group_name'];
						$jpg_file = $row['jpg_file'];
						$jpg_name = $row['jpg_name'];
						$jpg_memo = $row['jpg_memo'];
						$group_name = $row['group_name'];
						$g_file1 = $row['g_file1'];
						$g_file2 = $row['g_file2'];
						$g_file3 = $row['g_file3'];
						$url = "/";//$row['url'];
						$no = $row['no'];
						$day = $row['day'];


						echo "
						<div class='workView workView$num'>
							<div class='cont'>
								<div class='workHeader'>
									<a href=\"javascript:void(0)\" class='whleft'><img src='".KAPP_URL_T_."/include/img/btn/btn_workLeft02.png' /></a>

									<p class='t02'>Group : $group_name</p>
									<p class='t02'>Title   : $jpg_name</p>
									<a href='javascript:void();' class='whright nextwork'><img src='".KAPP_URL_T_."/include/img/btn/btn_workRight01.png' /></a>
								</div>
								<div class='workImg'>
									<p><img src='".KAPP_URL_T_."/data/main_scroll_image/$row[jpg_file]' /></p>
								</div>
								<div class='info'>
									<ul>
										<li>
											<span class='t01'>Title : </span>
											<span class='t02'>$jpg_name</span>
										</li>
										<li>
											<span class='t01'>Message : </span>
											<span class='t02'>$jpg_memo</span>
										</li>
										<li>
											<span class='t01'>Date : </span>
											<span class='t02'>$day</span>
										</li>
										<li>
											<span class='t01'>Group : </span>
											<span class='t02'>$group_name </span>
										</li>
									</ul>
									<a href='$url' target='_blank'>Home!</a>
								</div>
							</div>
						</div>
						";
					}
				}
?>
