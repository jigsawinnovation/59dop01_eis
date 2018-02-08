<h1>Front-end</h1>
<div style="background-color:#ccc; margin-top:50px">
news module(view) 
<?php 
	echo '<br> uri_seg 1: '.$this->uri->segment(1);
?>
</div>

<?php
if(uri_seg(2)=='template_show'){
?>
	<hr>
<?php
	echo 'Title: '.$title.'<br>';
	echo 'Tontent: '.$content;
?>
<?php
}
?>