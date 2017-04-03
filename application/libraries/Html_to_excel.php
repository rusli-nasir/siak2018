<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
	class Html_to_excel
	{
		var $xlsFile="Untitled.xls";
	
		function getHeader()
		{
			return "<%response.ContentType=\"application/vnd.ms-excel\"%>";
		}
		
		function setDocFileName($xlsfile)
		{
			$this->xlsFile=$xlsfile;
			if(!preg_match("/\.xls$/i",$this->xlsFile))
				$this->xlsFile.=".xls";
			return;		
		}
		
		function createXls($html,$file,$download=false)
		{
			$this->setDocFileName($file);
			$doc=$this->getHeader();
			$doc.=$html;
						
			if($download)
			{
				@header("Cache-Control: ");// leave blank to avoid IE errors
				@header("Pragma: ");// leave blank to avoid IE errors
				@header("Content-type: application/octet-stream");
				@header("Content-Disposition: attachment; filename=\"$this->xlsFile\"");
				echo $doc;
				return true;
			}
			else 
			{
				return $this->write_file($this->xlsFile,$doc);
			}
		}
		
		function write_file($file,$content,$mode="w")
		{
			$fp=@fopen($file,$mode);
			if(!is_resource($fp))
				return false;
			fwrite($fp,$content);
			fclose($fp);
			return true;
		}
	
	}
?>