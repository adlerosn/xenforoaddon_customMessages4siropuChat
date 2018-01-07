<?php

class customMessages4siropuChat_Model extends XenForo_Model {
	/* 
	 * Installation things
	 */ 
	public function install(){
		$this->_getDb()->fetchAll('CREATE TABLE IF NOT EXISTS xf_siropu_chat_custom_joinleave (
			uid INT PRIMARY KEY,
			j VARCHAR(255),
			l VARCHAR(255)
		) CHARACTER SET utf8 COLLATE utf8_general_ci;');
	}
	public function uninstall(){
		$this->_getDb()->fetchAll('DROP TABLE xf_siropu_chat_custom_joinleave');
	}
	/*
	 * Handlers for table `xf_siropu_chat_custom_joinleave`
	 */
	public function listJoinLeave(){
		return $this->_getDb()->fetchAll('SELECT * FROM xf_siropu_chat_custom_joinleave');
	}
	public function getJoinLeave($uid){
		return $this->_getDb()->fetchRow('SELECT * FROM xf_siropu_chat_custom_joinleave WHERE uid = ?',[$uid,]);
	}
	public function setJoinLeave($uid,$j,$l){
		if($j!='' && $l!=''){
			return $this->_getDb()->fetchAll('REPLACE INTO xf_siropu_chat_custom_joinleave (uid, j, l) VALUES (?,?,?)',[$uid,$j,$l,]);
		}else{
			return $this->delJoinLeave($uid);
		}
	}
	public function delJoinLeave($uid){
		return $this->_getDb()->fetchRow('DELETE FROM xf_siropu_chat_custom_joinleave WHERE uid = ?',[$uid,]);
	}
}
