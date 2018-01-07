<?php

class customMessages4siropuChat_Extend {
	public static function getExtensions(){
		return [
			['Siropu_Chat_DataWriter_Messages'  , 'customMessages4siropuChat_Extend_SiropuChatDWMessages'],
			['Siropu_Chat_ControllerPublic_Chat', 'customMessages4siropuChat_Extend_SiropuChatCPChat'],
		];
	}
	public static function callback($class, array &$extend){
		$xtds = static::getExtensions();
		foreach($xtds as $xtd){
			$baseClass = $xtd[0];
			$toExtend = $xtd[1];
			if($class==$baseClass && !in_array($toExtend, $extend)){
				$extend[]=$toExtend;
			}
		}
	}
}
