<?php

class customMessages4siropuChat_Extend_SiropuChatCPChat
extends XFCP_customMessages4siropuChat_Extend_SiropuChatCPChat {
	public function actionCustomJoinLeaveMessages(){
		if (!$this->_getHelper()->userHasPermission('customizeJoinLeave')){
			return $this->responseError(new XenForo_Phrase('do_not_have_permission'));
		};
		$model = XenForo_Model::create('customMessages4siropuChat_Model');
		if ($this->isConfirmedPost()){
			$model->setJoinLeave(
				XenForo_Visitor::getUserId(),
				$this->_input->filterSingle('join' , XenForo_Input::STRING),
				$this->_input->filterSingle('leave', XenForo_Input::STRING)
			);
			return $this->responseRedirect(
				XenForo_ControllerResponse_Redirect::SUCCESS,
				XenForo_Link::buildPublicLink('chat'),
				new XenForo_Phrase('siropu_chat_status_set')
			);
		};
		$user = array('name' => '');
		$original = [
			'join' =>(new XenForo_Phrase('siropu_chat_bot_room_join', $user, false))->render(),
			'leave'=>(new XenForo_Phrase('siropu_chat_bot_room_left', $user, false))->render(),
		];
		$current = $model->getJoinLeave(XenForo_Visitor::getUserId());
		return $this->responseView('', 'siropu_chat_joinLeaveMessage', array(
			'chatSession' => $this->session,
			'default' => $original,
			'current' => $current,
		));
	}
	public function actionBanned(){
		$r = parent::actionBanned();
		if($r instanceof XenForo_ControllerResponse_View){
			if('cgrt'==$this->_input->filterSingle('type',XenForo_Input::STRING)){
				$model = XenForo_Model::create('customMessages4siropuChat_Model');
				$toDel = $this->_input->filterSingle('del',XenForo_Input::UINT);
				if($toDel){
					$model->delJoinLeave($toDel);
					return $this->responseRedirect(
						XenForo_ControllerResponse_Redirect::SUCCESS,
						XenForo_Link::buildPublicLink('chat/banned','',['type'=>'cgrt'])
					);
				}
				$um = XenForo_Model::create('XenForo_Model_User');
				$jl = $model->listJoinLeave();
				foreach($jl as &$entry){
					$entry['user'] = $um->getUserById($entry['uid']);
				}
				$r->params['jl'] = $jl;
			}
		}
		return $r;
	}
}
