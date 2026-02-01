 <?php
		/*
		*   album_view_db_my.php, album_view_db.php, main_image_list.php, main_image_list.php 에서 콜.
		*/
				$SQL = " SELECT * from {$tkher['tkher_main_img_table']} where group_name!='main' or group_name!='shop' order by userid, view_no, no";
				if ( ($result = sql_query( $SQL ) )==false )
				{
				  printf("Invalid query: %s ", $SQL);
				  exit();
				} else {
                    $num=0;;
					while( $row = sql_fetch_array($result)  ) {
						$num++;
						$group_name = $H_ID; //$row['group_name'];
						$userid = $row['userid'];
						$jpg_file = $row['jpg_file'];
//						$f_path = KAPP_PATH_ . "/cratree/" . $H_ID . "/" . $row['jpg_file'];
//						$f_path = KAPP_URL_T_ . "/file/" . $H_ID . "/" . $row['jpg_file'];
						$f_path = KAPP_URL_T_ . "/file/" . $userid . "/" . $row['jpg_file'];
						$jpg_name = $row['jpg_name'];
						$jpg_memo = $row['jpg_memo'];
						$g_file1 = $row['g_file1'];
						$g_file2 = $row['g_file2'];
						$g_file3 = $row['g_file3'];
						$url = $row['url'];
						$no = $row['no'];
						$day = $row['day'];
						echo "
						<div class='workView workView$num'>
							<div class='cont'>
								<div class='workHeader'>
									<a href=\"javascript:void(0)\" class='whleft'><img src='".KAPP_URL_T_."/include/img/btn_Left02.png' /></a>
									<p class='t02'>User : $group_name </p>
									<p class='t02' title='id:$userid'>File : $jpg_name</p>
									<a href='javascript:void();' class='whright nextwork'><img src='".KAPP_URL_T_."/include/img/btn_Right01.png' /></a>
								</div>
								<div class='workImg'>
									<p><img src='$f_path' title='id: $userid'></p>
								</div>
								<div class='info'>
									<ul>
										<li>
											<span class='t01'>File</span>
											<span class='t02'>$jpg_name</span>
										</li>
										<li>
											<span class='t01'>Memo</span>
											<span class='t02'>$jpg_memo</span>
										</li>
										<li>
											<span class='t01'>Date</span>
											<span class='t02'>$day</span>
										</li>
										<li>
											<span class='t01'>User</span>
											<span class='t02'>$group_name </span>
										</li>
									</ul>
									<a href='/' target='_blank'>Home</a>
								</div>
							</div>
						</div>
						";
					}
				}
?>
