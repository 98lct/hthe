import axios from "axios";
import store from '../store/index';
/** Core */
export function getToken(){
    if (localStorage.getItem('token') != null) {
        return localStorage.getItem('token');
    }
    return false
}
export function getTokenExpires(){
    if (localStorage.getItem('expires_in') != null) {
        return localStorage.getItem('expires_in');
    }
    return false
}
export function saveToken(token, expires_in){
    localStorage.setItem('token', token);
    localStorage.setItem('expires_in', expires_in);
    return
}
export function removeToken(){
    return localStorage.clear()

}
export function post(url,creds){
    return axios.post(url, creds, {
        headers: {
          'Content-Type': 'multipart/form-data',
        }
    })
}
export function get(url, creds){
    return axios.get(url, creds)
}
/** Auth */
export function fetchLogin(){
    let state = store.state.auth;
    return post('/api/auth/login', {
        email: state.email,
        password: state.password
    });
}
export function fetchSignUp(){
    let state = store.state.signup;
    return post('/api/auth/signup', {
        email: state.email,
        password: state.password,
        gender: state.gender,
        first_name: state.first_name,
        last_name: state.last_name,
    });
}
export function fetchUser(){
    let state = store.state.auth;
    return post('/api/auth/user');
}
/** NewFeed & Post action */
export function updatePost(newfeed_id, newfeedKey, params = null){
    let state = store.state.newfeeds[newfeedKey];
    return post(`/api/newfeed/${newfeed_id}/update`, params);
}
export function disabledComment(newfeed_id){
    return get(`/api/newfeed/${newfeed_id}/disabled-comment`);
}
export function reactPost(newfeed_id){
    return get(`/api/newfeed/${newfeed_id}/react-post`);
}
export function showPost(newfeed_id){
    return get(`/api/newfeed/${newfeed_id}/show`);
}
export function destroyPost(newfeed_id){
    return get(`/api/newfeed/${newfeed_id}/destroy`);
}
export function getNewfeeds(user_id){
    let params = {
        'user_id': user_id
    }
    return post(`/api/newfeed`, params);
}
export function showUsersReact(newfeed_id){
    return get(`/api/newfeed/${newfeed_id}/react`);
}
export function sharedPost(newfeed_id, params){
    return post(`/api/newfeed/${newfeed_id}/share`, params);
}
export function changeStatus(newfeed_id, params){
    return post(`/api/newfeed/${newfeed_id}/status`, params);
}
export function uploadPost(params){
    return post(`/api/newfeed/upload`, params);
}
/** Comment action */
export function loadComment(newfeed_id){
    return get(`/api/newfeed/${newfeed_id}/comment`);
}
export function saveComment(newfeed_id, params){
    return post(`/api/newfeed/${newfeed_id}/save-comment`, params);
}
export function removeComment(commentID){
    return post(`/api/newfeed/${commentID}/remove-comment`);
}
/**Friends */
export function getFriends(){
    return post(`/api/u/`);
}
export function appectFriend(params){
    return post(`/api/u/request/appect`, params);
}
export function declineFriend(params){
    return post(`/api/u/request/decline`, params);
}
export function requestFriend(params){
    return post(`/api/u/request/send`, params);
}
export function unFriend(params){
    return post(`/api/u/unfriend`, params);
}
/** Notification */
export function readAll(object){
    return post(`/api/notification/read-all`, object);
}
export function listNotification(object){
    return post(`/api/notification/get-list`, object);
}
/** Chat */
// loadChat
export function loadChatFriend(id){
    return get(`/api/chat/${id}`);
}
// sendChat
export function sendChat(id, message){
    return post(`/api/chat/${id}/send`, {
        message: message
    });
}