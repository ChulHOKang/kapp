<?php
function GetFileSize($size) {
        if($size<1024) return ($size . "B");
        if($size >1024 && $size< 1024 *1024) return sprintf("%0.1fKB",$size / 1024);
		if($size >= 1024*1024) return sprintf("%0.2fMB",$size / (1024*1024));
}
?>