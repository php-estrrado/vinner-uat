<?php

class Chats extends CI_Model 
{

    function __construct() 
    {
        parent::__construct();
    }

    
    function getChatList($user, $id='') 
    {
        $this->db->where(array('user_id' => $user,'status'=>'1'));
        $this->db->order_by('last_message','desc');
        $chatlist_qry=$this->db->get('chat');
        if ($chatlist_qry->num_rows() > 0) 
        {
            $result['list'] = $chatlist_qry->result();
            $result['chatId'] = $chatId = 0;
            if($id>0) 
            {
                $result['chatId'] = $chatId = $id;
            }
            $this->db->select("*, DATE_FORMAT(created,'%h:%i:%p') as time ");
            $query = $this->db->order_by('created', 'asc')->get_where('chat_messages', array('chat_id' => $chatId, 'status' => 1));
            if ($query->num_rows() > 0) 
            {
                $result['details'] = $query->result();
            } else {
                $result['details'] = false;
            }
        }
        if($id)
            $this->updateChatStatus($user,$id);
        return $result;
    }

    function updateChatStatus($user,$id) 
    {
        $chat = $this->db->get_where('chat', array('chat_id' => $id, 'status' => 1))->row();
        if ($chat) 
        {
            if ($chat->user_id == $user) 
            {
                $this->db->where(array('user_id' => $user, 'chat_id' => $id, 'status' => 1))->update('chat', array('user_unread' => 0));
            } 
            if ($id > 0) 
            {
                $this->db->where(array('msg_to' => $user, 'chat_id' => $id, 'status' => 1))->update('chat_messages', array('unread' => 0));
            }
        }
    }
	
    function getChatMessages($chatId, $lastId) 
    {
        $this->db->select("*, DATE_FORMAT(created,'%h:%i:%p') as time ");
        $query = $this->db->where('chat_messages_id >', $lastId)->order_by('created', 'asc')->get_where('chat_messages', array('chat_id' => $chatId, 'status' => 1));
        $data = array();
        if ($query->num_rows() > 0) 
        {
            $data = $query->result();
            $test = json_encode($data);
            return json_encode($data);
        }
    }

    function saveChatMessage() 
    {
        $user = $user=$this->session->userdata('user_id');
        $chat = $this->db->get_where('chat', array('chat_id' => $this->input->get('chatId'), 'status' => 1))->row();
        if ($chat) 
        {
            if ($chat->vendor_id == $user) 
            {
                $msgTo = $chat->user_id;
                $readData = array('user_unread' => ($chat->user_unread + 1));
            } 
            else 
            {
                $msgTo = $chat->vendor_id;
                $readData = array('vendor_unread' => ($chat->vendor_unread + 1));
            }
            $data = array('chat_id' => $this->input->get('chatId'), 'msg_from' => $user, 'msg_to' => $msgTo, 'message' => $this->input->get('message'),'created'=>date("Y-m-d H:i:s"));
            $result = $this->db->insert('chat_messages', $data);
				$readData['last_message'] =date("Y-m-d H:i:s");
            $this->db->where('chat_id', $this->input->get('chatId'))->update('chat', $readData);
            if ($result) 
            { 
                return 1;
            } else {
                return 0;
            }
        }
    }
	
	function getvendorChatList($vendor, $id='') 
    {
        $this->db->where(array('vendor_id' => $vendor,'status'=>'1'));
        $this->db->order_by('last_message','desc');
        $chatlist_qry=$this->db->get('chat');
        if ($chatlist_qry->num_rows() > 0) 
        {
            $result['list'] = $chatlist_qry->result();
            $result['chatId'] = $chatId = 0;
            if($id>0) 
            {
                $result['chatId'] = $chatId = $id;
            }
            $this->db->select("*, DATE_FORMAT(created,'%h:%i:%p') as time ");
            $query = $this->db->order_by('created', 'asc')->get_where('chat_messages', array('chat_id' => $chatId, 'status' => 1));
            if ($query->num_rows() > 0) 
            {
                $result['details'] = $query->result();
            } else {
                $result['details'] = false;
            }
        }
        if($id)
            $this->updatevendorChatStatus($vendor,$id);
        return $result;
    }

    function updatevendorChatStatus($vendor,$id) 
    {
        $chat = $this->db->get_where('chat', array('chat_id' => $id, 'status' => 1))->row();
        if ($chat) 
        {
            if ($chat->vendor_id == $vendor) 
            {
                $this->db->where(array('vendor_id' => $vendor, 'chat_id' => $id, 'status' => 1))->update('chat', array('vendor_unread' => 0));
            } 
            if ($id > 0) 
            {
                $this->db->where(array('msg_to' => $vendor, 'chat_id' => $id, 'status' => 1))->update('chat_messages', array('unread' => 0));
            }
        }
    }
	
	function savevendorChatMessage() 
    {
        $vendor_id=$this->session->userdata('vendor_id');
        $chat = $this->db->get_where('chat', array('chat_id' => $this->input->get('chatId'), 'status' => 1))->row();
        if ($chat) 
        {
            if ($chat->vendor_id == $vendor_id) 
            {
                $msgTo = $chat->user_id;
                $readData = array('user_unread' => ($chat->user_unread + 1));
            } 
            else 
            {
                $msgTo = $chat->vendor_id;
                $readData = array('vendor_unread' => ($chat->vendor_unread + 1));
            }
            $data = array('chat_id' => $this->input->get('chatId'), 'msg_from' => $vendor_id, 'msg_to' => $msgTo, 'message' => $this->input->get('message'),'created'=>date("Y-m-d H:i:s"));
            $result = $this->db->insert('chat_messages', $data);
			$readData['last_message']=date("Y-m-d H:i:s");
            $this->db->where('chat_id',$this->input->get('chatId'))->update('chat', $readData);
            if ($result) 
            { 
                return 1;
            } else {
                return 0;
            }
        }
    }

}
