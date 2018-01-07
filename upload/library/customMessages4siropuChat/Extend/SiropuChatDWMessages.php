<?php

class customMessages4siropuChat_Extend_SiropuChatDWMessages
extends XFCP_customMessages4siropuChat_Extend_SiropuChatDWMessages {
	protected function _preSave(){
		$omessage = $this->get('message_text');
		$message = strval($omessage);
		$visitor = XenForo_Visitor::getInstance();
		$user = array('name' => '[USER=' . $visitor->user_id . ']' . $visitor->username . '[/USER]');
		$customs = XenForo_Model::create('customMessages4siropuChat_Model')->getJoinLeave(XenForo_Visitor::getUserId());
		if($message == (new XenForo_Phrase('siropu_chat_bot_room_join', $user, false))->render()){
			if(strlen($customs['j'])>0 && $visitor->hasPermission('siropu_chat','customizeJoinLeave')){
				$message = $user['name'].' '.$customs['j'];
			}
		} else
		if($message == (new XenForo_Phrase('siropu_chat_bot_room_left', $user, false))->render()){
			if(strlen($customs['l'])>0 && $visitor->hasPermission('siropu_chat','customizeJoinLeave')){
				$message = $user['name'].' '.$customs['l'];
			}
		}
		if($message!=$omessage){
			$this->set('message_text',$message);
		}
		return parent::_preSave();
	}
}
