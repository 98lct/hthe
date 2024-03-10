<template>
	<div class="main_content">
		<div class="mcontainer">
			<div class="messages-container">
				<div class="messages-container-inner">
					<div class="messages-inbox">
						<div class="messages-headline">
							<div class="input-with-icon" hidden>
								<input id="autocomplete-input" type="text" placeholder="Search">
								<i class="icon-material-outline-search"></i>
							</div>
							<h2 class="text-2xl font-semibold">Chats</h2>
							<span
								class="absolute icon-feather-edit mr-4 text-xl uk-position-center-right cursor-pointer"></span>
						</div>
						<div class="messages-inbox-inner" data-simplebar>
							<ul>
								<li v-for="friends in $store.getters.getFriends" @click="loadChat(friends.user_id, friends.full_name)"
									class="active-message">
									<a href="#">
										<div class="message-avatar"><i class="status-icon status-offline"></i>
											<img v-if="friends.profile_img == null" src="assets/images/avatars/avatar-2.jpg"
												 alt="">
											<img v-else :src="'/uploads/users/' + friends.profile_img" alt="">
											</div>

										<div class="message-by">
											<div class="message-by-headline">
												<h5>{{ friends.full_name }}</h5>
												<span>Yesterday</span>
											</div>
											<p>Sed diam nonummy nibh euismod tincidunt ut laoreet dolore</p>
										</div>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="message-content">
						<div class="messages-headline">
							<h4> {{ chat_friend }} </h4>
							<!-- <a href="#" class="message-action text-red-500"><i class="icon-feather-trash-2"></i> <span
									class="md:inline hidden"> Delete Conversation</span> </a> -->
						</div>
						<div class="message-content-scrolbar" data-simplebar>
							<!-- Message Content Inner -->
							<div class="message-content-inner">

								<!-- Time Sign -->
								<!-- <div class="message-time-sign">
	                                <span>28 June, 2020</span>
	                            </div> -->

								<div v-for="message in messengers" :class="message.senderID == $store.getters.getUser.user_id ? 'me message-bubble' : 'message-bubble'">
									<div class="message-bubble-inner">
										<div class="message-avatar">
											<img v-if="message.sender.profile_img == null" src="assets/images/avatars/avatar-2.jpg"
												alt="">
											<img v-else :src="'/uploads/users/' + message.sender.profile_img" alt="">
										</div>
										<div class="message-text">
											<p>{{ message.content}}</p>
										</div>
									</div>
									<div class="clearfix"></div>
								</div>

								<!-- <div class="message-bubble">
									<div class="message-bubble-inner">
										<div class="message-avatar"><img src="assets/images/avatars/avatar-2.jpg"
												alt=""></div>
										<div class="message-text">
											<p>Laoreet. dolore magna imperdiet quod mazim placerat facer possim. 👍</p>
										</div>
									</div>
									<div class="clearfix"></div>
								</div> -->









								<div class="clearfix"></div>
							</div>
						</div>
						<!-- Message Content Inner / End -->

						<!-- Reply Area -->
						<div class="message-reply">
							<textarea v-model="content" cols="1" rows="1" placeholder="Your Message"></textarea>
							<button @click="sendChat()" class="button ripple-effect">Send</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>

export default {
	data() {
		return {
			messengers: [],
			chat_friend: null,
			chat_friend_id: null,
			content: null
		}
	},
	updated() {
		// this.$nextTick(function () {
		// 	this.$el.querySelectorAll('.message-content-scrolbar')[0].scrollTop = this.$el.querySelectorAll('.message-content-scrolbar')[0].scrollHeight;
		// })
		// xuất hiện thông báo có tin nhắn chat mới channel chat


	

		
	},
	mounted(){
		window.Echo.channel('chat')
			.listen('NotificationPublished', (e) => {
				if (e.user_id == this.$store.getters.getUser.user_id) {
					this.$toast.default(e.notifications, { position: 'bottom-left', duration: 1000 });
					//this.messengers.push(e.message);
				
					// this.messengers = [...this.messengers, e.message];


					// chat
				}
			})
	},
	methods: {
		loadChat: function (id, full_name) {
			this.chat_friend = full_name;
			this.$store.dispatch('loadChat', id).then((response) => {
				this.messengers = response.data.messages;
				this.chat_friend_id = id;
			}).catch((error) => {
				console.log(error);
			});
		},
		sendChat: function () {
			this.$store.dispatch('sendChat', {
				id: this.chat_friend_id , 
				content: this.content
			}).then((response) => {
				// if(response.data.status == 'success'){
					this.messengers.push(response.data.messages);
					this.content = null;
					// gửi event lên server 
					// window.Echo.channel('load-notification')
        			// .listen('NotificationPublished'

					// gửi lên channel báo có tin nhắn mới cho người nhận
					// window.Echo.private('App.User.' + this.chat_friend_id)
					// .whisper('new-message', {
					// 	message: 'You have a new message'
					// });
					// Broadcast::channel('chat', function ($user) {
					// 	return $user;
					// });
// hiển thị thông báo cho người nhận
					//

					

				// }

			}).catch((error) => {
				console.log(error);
			});
		}
	}
}
</script>
<style scope></style>