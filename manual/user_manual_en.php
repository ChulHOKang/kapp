<?php
include_once('../tkher_start_necessary.php');
		$host	 = getenv("HTTP_HOST");
		/*
			소스 정 위치 : /manual/user_manual.php
		*/
	$ss_mb_id	= get_session("ss_mb_id");
	$ss_mb_level= $member['mb_level']; 
	$mb_point	= $member['mb_point'];
	$H_ID		= get_session("ss_mb_id");
	$from_session_id		= get_session("ss_mb_id");
	$H_LEV		= $member['mb_level'];  

	$ip  = $_SERVER['REMOTE_ADDR'];		
	$url1 = $_SERVER['PHP_SELF'];
	$url2 = $_SERVER['SCRIPT_FILENAME'];
	$url3 = $_SERVER['DOCUMENT_ROOT'];

	$agent  = getenv("HTTP_USER_AGENT");
	$Accept = getenv("HTTP_ACCEPT");
	$msg = $ip . "|" . $agent . "|" . $Accept;
	$pattern = "/mobile/i";
	if( preg_match($pattern, $agent, $matches)){
		$type='mobile';
	} else{
		$type='pc';
	}
	$ip_num = htol($ip);	//2342680517
	date_default_timezone_set("Asia/Seoul");
	$day = date("Y-m-d H:i:s");

?>
<html>
<head>
	<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8">
	<TITLE>K-APP. Create Apps with No Code. Chul Ho, Kang : solpakan89@gmail.com</TITLE> 
	<link rel="shortcut icon" href="../icon/logo25a.jpg">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta name="keywords" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
	<meta name="description" content="Create Apps with No Code, web app generator, no coding source code generator, CRUD, web tool, Best no code app builder, No code app creation ">
<meta name="robots" content="ALL">
</head>

<style>
/*This stylesheet sets the width of all images to 100%: */
img { width:100%; }
</style>

<body bgcolor='black'>

<a name="top"></a>
<ul align='center' >
<span style='width:100px;height:100px;background-color:black;'>
		<a href="<?=KAPP_URL_T_?>"><img src="<?=KAPP_URL_T_?>/logo/logo512-512.png" title="KAPP" style='width:100px;height:100px;background-color:black;'></a>
</span>
</ul>

<ul style='font-size:21px;color:yellow;'>
<p align='center'><b>K-APP</b></p>

<p style='font-size:21px;'>How to Use KAPP</p>
<a href="https://www.youtube.com/watch?v=HstNaNfthyM" target='_blank' style='color:skyblue'>1. Video on how to create a program and download the source code.</a><br>
<br>
<a href="https://www.youtube.com/watch?v=kamVb2L0zrg" target='_blank' style='color:skyblue'>2. Video on how to create a table and download the source code.</a><br>
<br>
<a href="https://www.youtube.com/watch?v=d3qgtXlF8NI" target='_blank' style='color:skyblue'>3. Video on how to create a tree menu and download the source code.</a><br>
<br>
<a href="https://www.youtube.com/watch?v=iUsi1MLG5H0" target='_blank' style='color:skyblue'>4. Video on how to set up a database.</a><br>
<br>
<a href="https://www.youtube.com/watch?v=T03pWCObXv8" target='_blank' style='color:skyblue'>5. Video on how to upload a database Excel file.</a><br>
<br>
<a href="#KAPP" style='color:skyblue'>* Run '<?=KAPP_URL_T_?>' in Chrome on your PC or phone.</a><br>
<br>
<a href="#Table_Design" style='color:white'>1. How to use Table_Design</a><br>
<a href="#Table_Source_download" style='color:white'>&nbsp;&nbsp;&nbsp;1.1 How to use Table Source Download</a><br>
<a href="#DB_Setup" style='color:white'>&nbsp;&nbsp;&nbsp;1.2 How to use DB_Setup</a><br>
<a href="#Table_Create" style='color:white'>&nbsp;&nbsp;&nbsp;1.3 How to create a table on the user server</a><br>
<a href="#Program_Create" style='color:white'>2. How to use Program Create</a><br>
<a href="#Program_Upgrade" style='color:white'>3. How to use Program Upgrade</a><br>
<a href="#Column_Attribute" style='color:white'>4. How to set up Column Attribute</a><br>
<a href="#Popup_Window" style='color:white'>&nbsp;&nbsp;&nbsp;4.1 How to set up Popup Window [Setup]</a><br>
<a href="#Formula" style='color:white'>&nbsp;&nbsp;&nbsp;4.2 Formula [Setup] How to set up</a><br>
<a href="#Attached_file" style='color:white'>&nbsp;&nbsp;&nbsp;4.3 How to set up attached file</a><br>
<a href="#Radio" style='color:white'>&nbsp;&nbsp;&nbsp;4.4 How to set up Radio Button</a><br>
<a href="#Checkbox" style='color:white'>&nbsp;&nbsp;&nbsp;4.5 How to Set a Checkbox Button</a><br>
<a href="#Listbox" style='color:white'>&nbsp;&nbsp;&nbsp;4.6 How to Set a Listbox Button</a><br>
<a href="#Table_Relationship" style='color:white'>5. How to Use Table Relationship</a><br>
<a href="#Sample Program" style='color:white'>6. How to Use the Sample Program</a><br>
<a href="#FTP Program" style='color:white'>7. How to Use the Program Source on Your Server</a><br>
<a href="#tree_menu" style='color:white'>8. How to Create a Tree Menu</a><br>

<a name="KAPP"></a>
<br><ul><li style='font-size:18px;'>Program-Make: Click 'Program-Make' in App Make on the main screen.</li></ul>
<img src='./pic_01.png' width='100%'>
<br><ul><li style='font-size:18px;'>Program-Make: </li></ul>
<img src='./pic_001.png' width='100%'>
<ul style='color:white'><li style='font-size:18px;'>Program-Make Description: </li></ul>
<a name="Table_Design"></a>
<br><ul><li style='font-size:18px;'>1. Table Design: Create a table.</li></ul>
<img src='./pic_table_create.png' width='100%'>
<ul style='color:white'><li> Description:
<br>1. Enter 'Table Name',
<br>2. Define 'column name' and 'data type',
<br>3. Enter 'size',
<br>4. Click the 'Create Table' button to create the table.
<br>5. Click the 'Reset' button to clear the input. </li></ul>
<br><ul><li style='font-size:18px;'>1.1 Table Creation Example: The order_test table is a list of columns.</li></ul>
<img src='./table_design_column_list.png' style='width:650px;height:450px;'>
<ul style='color:white'><li> Description:
<br>1. Click the 'del' button to delete a column. <br>2. Click the 'mod' button to save the column changes.
<br>3. Click the 'add' button to create additional columns.
<br>4. Click the 'Modification' button to save the table changes.
<br>5. Click the 'New Table' button to create a new table.
<br>6. Click the 'Reset' button to clear the input. </li></ul>
</li></ul>


<br><ul><li style='font-size:18px;'>1.2 Table List: This is a list of created tables.</li></ul>
<img src='./pic_003.png' width='100%'>
<ul style='color:white'><li> Description:
<br>1. Click the 'Delete' button to delete the table.
<br>2. Click the 'Download' button to download the data as an Excel file.
<br>3. Click the 'Upload' button to create the data in the table as an Excel file. <br>[Upload Excel Data Sample]<br>
<img src='./excel_data_sample.png' style='width:600px;height:360px'>
</li></ul>
<br><ul><li style='font-size:18px;'>1.2.1 Table Column List: Click 'Table Name' in the Table list to display the column list.</li></ul>
<img src='./pic_004.png' width='100%'>
<ul style='color:white'><li> Description:

<br>1. 'Data Insert' button: Runs the program to register data in the selected table.
<br>2. 'Data List' button: Displays the data list for the selected table.
<br>3. 'All Download' button: Downloads the compressed source code for table creation and database configuration.
<br>4. 'Create table only' button: Download the compressed table creation source code.
<br>5. 'Back Return' button: Go to the Table list.
</li></ul>

<a name="Table_Source_download"></a>

<br><ul><li style='font-size:18px;'>1.2.2 Clicking the All Download button: Click the 'Down RUN' button to download the source code and unzip it.</li></ul>
<img src='./All_Download_list.png' width='100%'>
<ul style='color:white'><li> Description:
<br>1. Click the 'Down RUN' button to download the source code.
<br>2. Unzip the downloaded file.
<br>3. Upload the files to your server via FTP and run 'urllink_index.php'.
<br>4. The open source FileZilla is the most commonly used FTP program.
<br> - FileZilla website: <a href="https://filezilla-project.org/">FTP FileZilla download site.</a>
</li></ul>

<a name="DB_Setup"></a>
<br><ul>
<li style='font-size:18px;'>1.2.3 DB Setup and Table Create: This is the screen after unzipping the downloaded file, uploading it to your server, and running 'urllink_index.php'.</li></ul>
<img src='./db_set_screen.png' width='100%'>
<ul style='color:white'><li> Description: '*Host Name' is almost always fixed to 'localhost'.
<br>1. DB Name
<br>2. DB User ID
<br>3. DB User Password
<br> The information to be entered here is known only to the server manager,<br> so you must contact the manager to enter it.</li></ul>
<br><ul><li style='font-size:18px;'>1.2.4 Create table only list: This screen is displayed when you click the 'Create table only' button in 1.3 Table Column List.
<br>Click the 'Down Run' button to download the source code and unzip it.</li></ul>
<img src='./Create_table_only_list.png' width='100%'>
<ul style='color:white'><li> Description: Click the 'Down Run' link to download, unzip the downloaded file, upload it to your server, and run 'urllink_index.php'.</li></ul>
<a name="Table_Create"></a>

<br><ul><li style='font-size:18px;'>1.2.5 Table Create: How to create a table on the user server. This is the screen after executing 'dao_1632726444_table_index.php'.
<br>[table name] + '_table_index.php' is the table creation executable file.
</li></ul>
<img src='./pic_020.png' width='100%'>
<ul style='color:white'><li> Description:
<br>1. The 'DB Reset' button takes you to the DB configuration screen.
<br>2. The 'Table Create' button creates the table 'dao_1632726444'. </li></ul>
<br><ul><li style='font-size:18px;'>1.2.6 DB Login: This is the screen that appears after running 'urllink_index.php' after completing DB Setup.</li></ul>
<img src='./DB_Login.png' width='100%'>
<ul style='color:white'><li> Description: After completing DB Setup, if you run 'urllink_index.php', the DB Login screen will appear. After logging in, you can reset the DB.
<br>For example, if you entered the DB Password incorrectly, you can reset it.</li></ul>
<a name="Table_Permissions"></a>
<br><ul><li style='font-size:18px;'>1.3 'Table Permissions': Set permissions for using the table.</li></ul>
<img src='./pic_019.png' width='100%'>
<ul style='color:white'><li> Description: Set the level at which the table can be read and written, depending on the user's level. <br>For example, if you want members with levels '2' and higher to be able to 'Read' and members with levels '3' and higher to be able to 'Write', set 'read level: 2' and 'write level: 3'.</li></ul>
<a href="#top">Top</a>
<a name="Program_Create"></a>
<br><ul><li style='font-size:18px;'>1.4 'Progeam Create': Create a program. </li></ul>
<img src='./pic_008.png' width='100%'>
<ul style='color:white'><li> Description: Create a new program.
<br>1. Select the table you want to use in 'Select table'. A list of filters will then be displayed.
<br>2. Enter a 'Program Name'
<br>3. Click the 'Create' button to create the program. <br>Clicking the 'Create' button will check for duplicate program names and create the program.
<br>Next, you can select a column and define its properties.
<br>Column properties can also be defined in <a href="#Program_Upgrade">'Program Upgrade'</a>.</li></ul>

<a href="#top">Top</a>
<a name="Program_Upgrade"></a>
<br><ul><li style='font-size:18px;'>1.5 'Program Upgrade': Modify and supplement the program. </li></ul>
<img src='./program_update.png' width='100%'>
<ul style='color:white'><li> Description: Select a program from the program list.
<br>Then, select a column and define its properties.
<br>'Program Upgrade' allows you to modify and supplement column properties.
</li></ul>

<a href="#top">Top</a>
<a name="Column_Attribute"></a>
<br><ul><li style='font-size:18px;'>1.5.1 How to define column properties.
<br> 1.5.1.1 How to set the column property to 'POPUP Window'. <br>Example) Here's how to set the 'id' column property to 'POPUP Window'.
<br>1. Select column 'id'
<br>2. Click 'POPUP Window[Setup]'. This will display the Popup Window settings screen. </li></ul>
<img src='./pic_010.png' width='100%'>

<a name="Popup_Window"></a>
1.5.1.2 This screen sets the 'id' column property to 'Popup Window'.
<img src='./pic_026_Popup_Window.png' width='100%'>
<br>There are two windows: the Popup Window and the Program Window.
<br>The 'product' table in the Popup Window is used in the popup window, and the 'order_tab' table in the Program Window is used in the program.
<br>1. Select Table in the Popup Window. The following screen shows the 'product' table selected.
<img src='./pic_027_Popup_window.png' width='100%'>
<ul style='color:white'><li> Description:
<br>Delete unused columns from the popup window when running the program.
<br>To delete, 1. Select a column, and 2. Click the 'Del' button.
<br>Here's how to link columns:
<br>1. Select the 'product' column in the popup window, the 'id' column in the program window, and click the 'Apply' button.
<br>2. Select the 'cost' column in the popup window, the 'unit_price' column in the program window, and click the 'Apply' button.
<br>3. Select the 'price' column in the Popup Window, then select the 'price' column in the Program Window and click the 'Apply' button.
<br>4. Click the 'Save' button to save. The following result will be displayed.</li></ul>
<img src='./pic_028_Popup_window.png' width='100%'>

<a href="#top">Top</a>
<a name="Formula"></a>

<br><br><ul><li style='font-size:18px;'>1.5.1.2 How to set the column property to 'Formula'.

<br>Formula is a method for setting a calculation formula.
<br>This is an example of setting the column 'price' as a Formula property.
<br>1. Select column 'price'. <br>2. Click 'Formula [Setup]'.
</li></ul>
<img src='./pic_029_formula.png' width='100%'>
Select column 'price' and click the 'Formula [Setup]' button to display the formula setup screen. <img src='./pic_018_formula.png' width='100%'>
<ul style='color:white'><li> Description: <br>
For example, if "Amount = Unit Price * Quantity" is used, the amount will be calculated and automatically displayed when you enter the unit price and quantity in the input screen.

<br>Calculation Formula Setting Process
<br>1. Click the "quantity" column.
<br>2. Click "*(multiply)".
<br>3. Click the "unity_price" column. The "Formula" field will display "price = quantity * unit_price."
<br>4. Click the "Save" button to save.
</li></ul>
<a name="Radio"></a>
<br><ul><li style='font-size:18px;color:yellow;'>1.5.1.3 How to set the column property to "Radio". </li></ul>
<img src='./pic_030_radio.png' width='100%'>
<ul style='color:white'><li> Description: This method allows you to select data instead of entering it directly.
<br> There are three types of buttons: 'Radio', 'Checkbox', and 'Listbox'.
<br>Of these, 'Checkbox' allows multiple selections. Radio and Listbox only allow single selections.
<br>After selecting one of 'Radio', 'Checkbox', or 'Listbox', enter the data in the 'Column attribute data' field and click the 'Apply Attribute' button.
<br>To set the input attributes for the 'unit' column:
<br>1. Click the 'unit' column.
<br>2. Enter 'ea:box' in '*Column attribute data' and separate the items with a comma.
<br>3. Click the 'Radio' button.
<br>4. Click the 'Apply Attribute' button.
<br>Another example) For hobbies, enter "Soccer:Basketball:Volleyball:Golf:Baseball:Baduk:Hiking:Fishing," click the "Checkbox," and then click the "Apply Attribute" button.
<br>For hobbies, the "Checkbox" option is often used, allowing you to select multiple items.
</li></ul>

<a name="Checkbox"></a>
<br><ul><li style='font-size:18px;color:yellow;'>1.5.1.4 How to set the 'Checkbox' attribute. 'Checkbox' allows multiple selections.</li></ul>
<img src='./pic_053_Checkbox.png' width='100%'>
<ul style='color:white'><li> Description:
<br>1. Select the 'standard' column.
<br>2. Enter 'mm:cm:m' in '*Column attribute data'.
<br>3. Select 'Checkbox'.
<br>4. Click the 'Apply Attribute' button.
<br>The item separator is ':'. </li></ul>
<a href="#top">Top</a>
<a name="Listbox"></a>
<br><ul><li style='font-size:18px;color:yellow;'>1.5.1.5 How to set the 'Listbox' attribute. Here's an example for the 'manufacturer' column.</li></ul>
<img src='./pic_054_Listbox.png' width='100%'>
<ul style='color:white'><li> Description:
<br>1. Select the 'manufacturer' column.
<br>2. Enter "apple:samsung" in the '*Column attribute data' field.
<br>3. Select 'Listbox'.
<br>4. Click the 'Apply Attribute' button.
<br>The item separator is ':'. </li></ul>
<a href="#top">Top</a>
<a name="Attached_file"></a>
<br><ul><li style='font-size:18px;color:yellow;'>1.5.1.6 How to set the 'Attached file' attribute. </li></ul>
<img src='./pic_032_Attached_file.png' width='100%'>
<ul style='color:white'><li> Description: The 'Attached file' attribute is used when registering an attached file.
<br>For example, select this attribute when attaching a product photo or document file.
</li></ul>
<a href="#top">Top</a>

<br><ul><li style='font-size:18px;color:yellow;'>1.5.1.5 How to Change a Column Name. </li></ul>
<img src='./pic_032_Attached_file.png' width='100%'>
<ul style='color:white'><li> Description: Change the column name.
<br>1. Click a column.
<br>2. Change the name in '*Change column name' and enter it.
<br>3. Click the 'Confirm' button.
<br>4. Click the 'Save and Run' button to save.
</li></ul>
<a name="Table_Relationship"></a>
<br><ul><li style='font-size:18px;color:yellow;'>1.6.1 Setting 'Table Relationship'. <br>'Table Relationship' is a table relationship.
<br>When registering data in Table A, it is set to simultaneously register data in Table B.
</li></ul>
<img src='./pic_relation1.png' width='100%'>
<ul style='color:white'><li> Description: 'Table Relationship' is a table relationship. When registering data in Table A, it is set to simultaneously register data in Table B.
<br>For example, when registering an order and issuing a shipping instruction simultaneously, you would set up a 'Table Relationship'.
<br>How to set up a 'Table Relationship':
<br>1. Select Program.
<br>2. Select 'Relation table'.
<br>3. Select a column in the 'Program table', then select a column in the 'Relation table', then select the column movement type, and click the 'Apply' button.
<br>4. Once you've completed the column movement settings, click the "Save" button to save.
<br>The following screen displays the work order. </li></ul>
<img src='./pic_relation2.png' width='100%'>
<ul style='color:white'><li> Description: This is the screen where 'Progeam' is selected.</li></ul><br>
<img src='./pic_relation3.png' width='100%'>
<ul style='color:white'><li> Description: This is the screen where 'Relation table' is selected.</li></ul><br>
<img src='./pic_relation4.png' width='100%'>
<ul style='color:white'><li> Description: This is the screen where columns are selected to set table relationships and the 'Apply' button is clicked.</li></ul><br>
<img src='./pic_relation5.png' width='100%'>
<ul style='color:white'><li> Description: This is the screen where you select "Program" after completing the relationship settings.
<br>To delete a "Table Relationship," click the "Delete" button.</li></ul><br>
<a href="#top">Top</a>

<a name="Sample Program"></a>
<br><ul><li style='font-size:18px;color:yellow;'>1.7.1 Sample Program 'order_tab' Data Registration Screen. </li></ul>
<img src='./pic_038_sample.png' width='100%'>
<ul style='color:white'><li> Description: This is the sample program order_tab data registration screen.
<br>The 'submit' button saves the data.
<br>The 'reset' button clears the entered data from the screen and prompts you to re-enter it.
<br>The 'Source Down' button downloads the data registration source code.
<br>The 'List' button moves to the data list.
<br>The 'Select File' button for the 'image' column appears when 'Attached file' is selected in the column properties. </li></ul>
<br><ul><li style='font-size:18px;color:yellow;'>1.7.2 Sample program order_tab's pop-up window execution screen. </li></ul>
<img src='./pic_037_sample2.png' width='100%'>
<ul style='color:white'><li> Description: This is the pop-up window launched by clicking the registered column 'id'.
<br>This was launched by setting the column properties of 'id' by clicking the 'POPUP Window [Setup]' button.
</li></ul>
<br><ul><li style='font-size:18px;color:yellow;'>1.7.3 Sample program order_tab's data list screen. </li></ul>
<img src='./pic_038_sample_list.png' width='100%'>
<ul style='color:white'><li> Description: Data list screen for the sample program order_tab.
<br>The 'Write' button moves to the data registration screen.
<br>The 'Excel Down' button downloads the data as an Excel file.
<br>The 'Source Down' button downloads the data list program source code.
</li></ul>

<br><ul><li style='font-size:18px;color:yellow;'>1.7.4 Data details screen for the sample program order_tab. </li></ul>
<img src='./pic_052_sample3.png' width='100%'>
<ul style='color:white'><li> Description: This screen appears when you click an item in the data list of the sample program order_tab.
<br>The 'Modify' button takes you to the data modification screen.
<br>The 'Delete' button deletes data.
<br>The 'List' button takes you to the data list.
<br>The 'Source Down' button downloads the source code for modifying and deleting data.
</li></ul>

<br><ul><li style='font-size:18px;color:yellow;'>1.7.5 Data registration screen of the sample program order_tab. </li></ul>
<img src='./write.png' width='100%' style='height:450px;width:600px;'>
<ul style='color:white'><li> Description: Data list screen of the sample program order_tab.
<br>The 'submit' button registers data.
<br>The 'reset' button re-enters data.
<br>The 'Source Down' button downloads the data list program source code.
<br>The 'Excel Upload' button saves data from an Excel file to a table.
<br>[Sample Excel file]
<br><img src='./excel_data_sample.png' style='width:600px;height:360px'>
</li></ul>

<a name="FTP program"></a>
<br><br>
<br><ul><li style='font-size:18px;color:yellow;'>1.7.6 How to use the source on a user server. This is the FTP 'Filezilla' execution screen. </li></ul>
<img src='./pic_055_FTP.png' width='100%'>
<ul style='color:white'><li> Description:

<br>To use the source on a user server, click the 'Source Down' button to download it.

<br>Unzip the file and upload it to the server using the 'FTP' program. The open source FTP program FileZilla is the most commonly used. <br>The FileZilla site is: <a href="https://filezilla-project.org/">FTP FileZilla download site.</a>
</li></ul>
<a href="#top">Top</a>
<a name="tree_menu"></a>
<br><ul>
<li style='font-size:18px;color:yellow;'>8 How to Create a Tree Menu
[Tree Menu List]<br><img src='./menu0.png' style='width:36%;height:80%;'></li></ul>
<ul style='color:white'>
<li> Description: This is your tree menu list.
<br>You can create menus and download the source code.
<br>1. The 'New Create' button creates a menu.
<br>2. The 'Tree DN' button generates and downloads the 'Tree menu' source code. <br>3. The 'Popup DN' button generates and downloads the 'Popup menu' source code.
<br>4. Clicking the 'Title' item launches the 'Tree menu.'
<br>5. Clicking 'Popup' launches the 'Popup menu.'
</li></ul>
<br><ul>
<li style='font-size:18px;color:yellow;'>8.1 Tree Menu Source Code DownLoad
<br><img src='./menu_source.png' style='width:60%;height:60%;'></li></ul>
<ul style='color:white'>
<li> Description: This is the screen after clicking the 'Tree DN' button in the 'Tree Menu List.'
<br>1. Click 'Download Action' to download the source code.
<br>2. Click the 'Popup DN' button in the 'Tree Menu List' to download the 'Popup menu' source code.
</li></ul>


<ul><li style='font-size:18px;color:yellow;'>8.2 Create a Tree Menu: [Menu Creation Screen] - Click the 'New Create' button in the 'Tree Menu List'.
<br><img src='./menu_create.png' style='width:36%;height:80%;'></li></ul>
<ul style='color:white'>
<li> Description: Create a custom tree menu.
<br>1. Click the 'Creates' button to create a menu.
<br>2. Click the 'Tree-Menu List' button to move to the menu list screen.
<br>3. 'Background Color': The background color of the menu.
<br>4. 'Font Color': The text color of the menu.
<br>5. 'Font': The text font. </li></ul>
<ul><li style='font-size:18px;color:yellow;'>8.3 Tree Menu Job: [Menu Execution Screen] - Add, change, and delete menus.
<br><img src='./menu_job.png' style='width:50%;height:80%;'></li></ul>
<ul style='color:white'>
<li> Description: Click 'Select Job' to select a job.
<br>1. 'Insert job' adds a menu.
<br>1. 'Update job' allows you to change the menu title and link 'url'.
<br>1. Click 'Execute' to execute the menu.
<br>1. 'Tree design' resets the design. </li></ul>
<ul><li style='font-size:18px;color:yellow;'>8.4 Menu Insert
[Add Menu] - Click the 'Insert Job' button under 'Select Job'.</li></ul>
<li><img src='./menu_insert2.png' style='width:80%;height:90%;'></li>
<ul style='color:white'>
<li> Description: Click 'Insert Job'.
<br>1. 'Link' links to a URL.
<br>2. 'Note' creates a note.
<br>3. 'Board' creates a bulletin board. </li></ul>

<ul><li style='font-size:18px;color:yellow;'>8.5 Menu Insert
[Add Menu] - After adding a menu, click the 'Insert Job' button again and select 'Sports'. This is the screen after clicking.</li></ul>
<li><img src='./menu_insert4.png' style='width:80%;height:90%;'></li>
<ul style='color:white'>
<li> Description: Add a menu below 'Sports'.
<br>1. 'Save' saves the menu.
<br>2. The 'Switch to Main Level' button changes the current 'Sports' menu back to the 'Main Level Menu' registration.
</li></ul>

<ul><li style='font-size:18px;color:yellow;'>8.6 Menu Update
<br>[Menu Change and Delete] - Change or delete a menu. Click the 'Update Job' button.</li></ul>
<li><img src='./menu_update.png' style='width:80%;height:70%;'></li>
<ul style='color:white'>
<li> Description: Change or delete the tree menu.
<br>Click the 'Save' button to save the title changes.
<br>The 'Search' button searches for and selects a link URL.
<br>Click the 'Delete' button to delete it from the menu. <li>[Search Click Screen]<br><img src='./menu_search.png' style='width:45%;height:70%;'></li>
</li></ul>

<ul><li style='font-size:18px;color:yellow;'>8.7 Tree Menu Design.
<br>[Change Menu Design] - Click the 'Tree Design' button.</li></ul>
<li><img src='./menu_design_set.png' style='width:70%;height:70%;'></li>
<ul style='color:white'>
<li> Description: Change the design of the tree menu.
<br>Change the menu background color, text color, text size, etc.
</li></ul>

<ul><li style='font-size:18px;color:yellow;'>8.8 How to Use Note. <br>[From the menu] -> Click 'My-Job'.</li></ul>
<li><img src='./menu_note.png' style='width:54%;height:70%;'></li>
<ul style='color:white'>
<li> Description: When you create a tree menu, the main title is 'Note.'
<br>Click the main title a second time to change the title and content.
<br>The content can be encrypted and saved. If you lose your password, you cannot decrypt it. This is important.
<li>[Encrypted content screen]<br><img src='./menu_note_encryption.png' style='width:45%;height:70%;'></li>
Enter your password and click the 'Decryption' button to decrypt it.
</li></ul>

<ul><li style='font-size:18px;color:yellow;'>9. Sometimes, even after adding a menu, the menu doesn't update.
<br>This is because the browser is having trouble updating the new content. Here's how to fix it:
<br>1. Click Settings in Chrome.
<br>2. Click the "Delete Cached Image Files" button.
<li><img src='./menu_crome_cookie_delete.png' style='width:90%;height:70%;'></li>
<ul style='color:white'>
<li> Description: Click Settings in the upper right corner of the browser.
<br>Click the "Delete Cached Image Files" button.
<br>Refresh the menu screen to display the menu normally.</li></ul>
<a href="#top">Top</a>
