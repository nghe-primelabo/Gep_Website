gep = {
	flash: {
		enabled: function(){

			//alert('check Flash uploading!');
			// ie
			try
			{
				try
				{
					// avoid fp6 minor version lookup issues
					// see: http://blog.deconcept.com/2006/01/11/getvariable-setvariable-crash-internet-explorer-flash-6/
					var axo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash.6');
					try
					{
						axo.AllowScriptAccess = 'always';
					}
					catch(e)
					{
						return '6,0,0';
					}
				}
				catch(e)
				{
				}
				return new ActiveXObject('ShockwaveFlash.ShockwaveFlash').GetVariable('$version').replace(/\D+/g, ',').match(/^,?(.+),?$/)[1];
			// other browsers
			}
			catch(e)
			{
				try
				{
					if(navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin)
					{
						return (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]).description.replace(/\D+/g, ",").match(/^,?(.+),?$/)[1];
					}
				}
				catch(e)
				{
				}
			}
			return false;
		}
	},
	notifications: {
		showWindow: function (){
			var ajaxCall = 'jax.call("community", "notification,ajaxGetNotification", "")';
			cWindowShow(ajaxCall, '', 450, 100);
		},
		updateNotifyCount: function (){
			var notifyCount	= jQuery('#toolbar-item-notify-count').text();

			if(jQuery.trim(notifyCount) != '' && notifyCount > 0)
			{
				//first we update the count. if the updated count == 0, then we hide the tab.
				notifyCount = notifyCount - 1;
				jQuery('#toolbar-item-notify-count').html(notifyCount);
				if (notifyCount == 0)
				{
					jQuery('#toolbar-item-notify').hide();
				}
			}
		}
	},
	filters:{
		bind: function(){
			var loading	= this.loading;
			jQuery(document).ready( function()
			{
				//sorting option binding for members display
				jQuery('.newest-member').bind('click', function() {
				    if ( !jQuery(this).hasClass('active-state') ) {
				        loading( jQuery(this).attr('class') );
						jax.call('community', 'frontpage,ajaxGetNewestMember', frontpageUsers);
					}
				});
				jQuery('.active-member').bind('click', function() {
				    if ( !jQuery(this).hasClass('active-state') ) {
			            loading( jQuery(this).attr('class') );
						jax.call('community', 'frontpage,ajaxGetActiveMember', frontpageUsers);
					}
				});
				jQuery('.popular-member').bind('click', function() {
				    if ( !jQuery(this).hasClass('active-state') ) {
				        loading( jQuery(this).attr('class') );
				    	jax.call('community', 'frontpage,ajaxGetPopularMember', frontpageUsers);
					}
				});
				jQuery('.featured-member').bind('click', function() {
				    if ( !jQuery(this).hasClass('active-state') ) {
				        loading( jQuery(this).attr('class') );
				    	jax.call('community', 'frontpage,ajaxGetFeaturedMember', frontpageUsers);
					}
				});

				//sorting option binding for activity stream
				jQuery('.all-activity').bind('click', function() {
				    if ( !jQuery(this).hasClass('active-state') ) {
			            loading( jQuery(this).attr('class') );
						jax.call('community', 'frontpage,ajaxGetActivities', 'all');
					}
				});
				jQuery('.me-and-friends-activity').bind('click', function() {
				    if ( !jQuery(this).hasClass('active-state') ) {
				        loading( jQuery(this).attr('class') );
				    	jax.call('community', 'frontpage,ajaxGetActivities', 'me-and-friends');
					}
				});
				jQuery('.active-profile-and-friends-activity').bind('click', function() {
				    if ( !jQuery(this).hasClass('active-state') ) {
				        loading( jQuery(this).attr('class') );
				    	jax.call('community', 'frontpage,ajaxGetActivities', 'active-profile-and-friends', mm.user.getActive());
					}
				});
				jQuery('.active-profile-activity').bind('click', function() {
				    if ( !jQuery(this).hasClass('active-state') ) {
				        loading( jQuery(this).attr('class') );
				    	jax.call('community', 'frontpage,ajaxGetActivities', 'active-profile', mm.user.getActive());
					}
				});
				jQuery('.p-active-profile-and-friends-activity').bind('click', function() {
				    if ( !jQuery(this).hasClass('active-state') ) {
				        loading( jQuery(this).attr('class') );
				    	jax.call('community', 'frontpage,ajaxGetActivities', 'active-profile-and-friends', mm.user.getActive(), 'profile');
					}
				});
				jQuery('.p-active-profile-activity').bind('click', function() {
				    if ( !jQuery(this).hasClass('active-state') ) {
				        loading( jQuery(this).attr('class') );
				    	jax.call('community', 'frontpage,ajaxGetActivities', 'active-profile', mm.user.getActive(), 'profile');
					}
				});

				// sorting and binding for videos
				jQuery('.newest-videos').bind('click', function() {
				    if ( !jQuery(this).hasClass('active-state') ) {
				        loading( jQuery(this).attr('class') );
						jax.call('community', 'frontpage,ajaxGetNewestVideos', frontpageVideos);
					}
				});
				jQuery('.popular-videos').bind('click', function() {
				    if ( !jQuery(this).hasClass('active-state') ) {
				        loading( jQuery(this).attr('class') );
				    	jax.call('community', 'frontpage,ajaxGetPopularVideos', frontpageVideos);
					}
				});
				jQuery('.featured-videos').bind('click', function() {
				    if ( !jQuery(this).hasClass('active-state') ) {
				        loading( jQuery(this).attr('class') );
				    	jax.call('community', 'frontpage,ajaxGetFeaturedVideos', frontpageVideos);
					}
				});

				// remove last link border
				jQuery('.popular-member').css('border-right', '0').css('padding-right', '0');
				jQuery('.me-and-friends-activity').css('border-right', '0').css('padding-right', '0');
				jQuery('.active-profile-activity').css('border-right', '0').css('padding-right', '0');
			});
		},
		loading: function(element){
			elParent = jQuery('.'+element).parent().parent().attr('id');
			if ( elParent === '' ) {
		        elParent = jQuery('.'+element).parent().attr('id');
			}
		    jQuery('#' + elParent + ' .loading').show();
		    jQuery('#' + elParent + ' a').removeClass('active-state');
		    jQuery('.'+element).addClass('active-state');
		},
		hideLoading: function(){
			jQuery( '.loading' ).hide();
			// rebind the tooltip
			jQuery('.jomTipsJax').addClass('jomTips');
			mm.tooltip.setup();
		}
	},
	groups: {
		addInvite: function( element ){
			var parentId = jQuery('#' +element).parent().attr('id');

			if(parentId == "friends-list")
			{
				jQuery("#friends-invited").append(jQuery('#' +element)).html();
			}
			else
			{
				jQuery("#friends-list").append(jQuery('#' +element)).html();
			}
		},
		removeTopic: function( title , groupid , topicid ){
			var ajaxCall = 'jax.call("community","groups,ajaxShowRemoveDiscussion", "' + groupid + '","' + topicid + '");';
			cWindowShow(ajaxCall, title, 450, 100);
		},
		editBulletin: function(){

			if( jQuery('#bulletin-data').css('display') == 'none' )
			{
				jQuery('#bulletin-data').show();
				jQuery('#bulletin-edit-data').hide();
			}
			else
			{
				jQuery('#bulletin-data').hide();
				jQuery('#bulletin-edit-data').show();
			}

		},
		removeBulletin: function( title , groupid , bulletinid ){
			var ajaxCall = 'jax.call("community", "groups,ajaxShowRemoveBulletin", "' + groupid + '","' + bulletinid + '");';
			cWindowShow(ajaxCall, title, 450, 100);
		},
		unpublish: function( groupId ){
			jax.call( 'community' , 'groups,ajaxUnpublishGroup', groupId);
		},
		leave: function( groupid ){
			var ajaxCall = 'jax.call("community", "groups,ajaxShowLeaveGroup", "' + groupid + '");';
			cWindowShow(ajaxCall, '', 450, 100);
		},
		joinWindow: function( groupid ){
			var ajaxCall = 'jax.call("community", "groups,ajaxShowJoinGroup", "' + groupid + '", location.href );';
			cWindowShow(ajaxCall, '', 450, 100);
		},
		edit: function(){
			// Check if input is already displayed
			jQuery('#community-group-info .cdata').each(function(){
				// Test if the next div is cinput

				if(jQuery(this).next().html() && jQuery(this).css('display') != 'none' )
					jQuery(this).css('display' , 'none');
				else
					jQuery(this).css('display' , 'block');
			});

			jQuery('#community-group-info .cinput').each(function(){
				if(jQuery(this).css('display') == 'none')
					jQuery(this).css('display' , 'block');
				else
					jQuery(this).css('display' , 'none');
			});

			if(jQuery('div#community-group-info-actions').css('display') != 'none')
				jQuery('div#community-group-info-actions').css('display' , 'none');
			else
				jQuery('div#community-group-info-actions').css('display' , 'block');
		},
		save: function( groupid ){
			var name		= jQuery('#community-group-name').val();
			var description	= jQuery('#community-group-description').val();
			var website		= jQuery('#community-group-website').val();
			var category	= jQuery('#community-group-category').val();
			var approvals	= jQuery("input[@name='group-approvals']:checked").val();

			jax.call('community' , 'groups,ajaxSaveGroup' , groupid , name , description , website , category , approvals);
		},
		update: function( groupName , groupDescription , groupWebsite , groupCategory){
			// Re-update group data
			jQuery('#community-group-data-name').html( groupName );
			jQuery('#community-group-data-description').html( groupDescription );
			jQuery('#community-group-data-website').html( groupWebsite );
			jQuery('#community-group-data-category').html( groupCategory );
			this.edit();
		},
		removeMember: function( memberId , groupId ){
			jax.call('community', 'groups,ajaxRemoveMember', memberId , groupId );
		},
		deleteGroup: function( groupId ){
			var ajaxCall = "jax.call('community', 'groups,ajaxWarnGroupDeletion', '" + groupId + "');";
			cWindowShow(ajaxCall, '', 450, 100, 'warning');
		}
	},
	friends: {
		saveTag: function(){
			var formVars = jax.getFormValues('tagsForm');
			jax.call("community", "friends,ajaxFriendTagSave", formVars);
			return false;
		},
		saveGroup: function(userid) {
			if(document.getElementById('newtag').value == ''){
			    window.alert('TPL_DB_INVALIDTAG');
			}else{
				jax.call("community", "friends,ajaxAddGroup",userid,jQuery('#newtag').val());
			}
		},
		cancelRequest: function( friendsId ){
			var ajaxCall = 'jax.call("community" , "friends,ajaxCancelRequest" , "' + friendsId + '");';
			cWindowShow(ajaxCall, '', 450, 100);
		},
		connect: function( friendid ){
			var ajaxCall = 'jax.call("contestants", "friends,ajaxConnect", '+friendid+')';
			cWindowShow(ajaxCall, '', 450, 100);
		},
		addNow: function(){
		 	var formVars = jax.getFormValues('addfriend');
		 	jax.call("contestants", "friends,ajaxSaveFriend",formVars);
		 	return false;
		}
	},
	messaging: {
		loadComposeWindow: function(userid){
			var ajaxCall = 'jax.call("contestants", "inbox,ajaxCompose", '+userid+')';
			cWindowShow(ajaxCall, '', 450, 100);
		},
		send: function(){
			var formVars = jax.getFormValues('writeMessageForm');
			jax.call("contestants", "inbox,ajaxSend", formVars);
			return false;
		}
	},
	walls: {
		add: function ( uniqueId, addFunc ){

			//alert(uniqueId);

			jaxcontestant.loadingFunction = function()
			{
				jQuery('#wall-message').attr('disabled', true);
				jQuery('#wall-submit').attr('disabled', true);
			}

			jaxcontestant.doneLoadingFunction = function()
			{
				jQuery('#wall-message').attr('disabled', false);
				jQuery('#wall-submit').attr('disabled', false);
			};

			if(typeof getCacheId == 'function')
			{
				cache_id = getCacheId();
			}
			else
			{
				cache_id = "";
			}

			jaxcontestant.call_contestants("contestants", "photos", "ajaxSaveWall", jQuery('#wall-message').val(), uniqueId, cache_id);
			//jaxcontestant.call_contestants
		},
		insert: function( html ){
			//alert('Nghe');
			jQuery('#wall-message').val('');
			jQuery('#wallContent').prepend(html);
		},
		remove: function( type , wallId , contentId ){
			if(confirm('Are you sure you want to delete this wall?'))
			{
				jax.call('community' , type + ',ajaxRemoveWall' , wallId , contentId );
				jQuery('#wall_' + wallId ).fadeOut('normal', function(){jQuery(this).remove()});

				// Process ajax calls
			}
		}
	},
	JVXVoting:{
		JVXVote: function(id,i,total,total_count,xid,counter){

		}
	},
	toolbar: {
		timeout: 500,
		closetimer: 0,
		ddmenuitem: 0,
		open: function( id ){

			if ( jQuery('#'+id).length > 0 ) {
				// cancel close timer
				mm.toolbar.cancelclosetime();

				// close old layer
				if(mm.toolbar.ddmenuitem)
				{
					mm.toolbar.ddmenuitem.style.visibility = 'hidden';
				}

				// get new layer and show it
				mm.toolbar.ddmenuitem = document.getElementById(id);
				mm.toolbar.ddmenuitem.style.visibility = 'visible';
			}
		},
		close: function(){
			if(mm.toolbar.ddmenuitem)
			{
				mm.toolbar.ddmenuitem.style.visibility = 'hidden';
			}
		},
		closetime: function(){
			mm.toolbar.closetimer	= window.setTimeout( mm.toolbar.close , mm.toolbar.timeout );
		},
		cancelclosetime: function(){
			if( mm.toolbar.closetimer )
			{
				window.clearTimeout( mm.toolbar.closetimer );
				mm.toolbar.closetimer = null;
			}
		}
	},
	registrations:{
		windowTitle: '',
		showTermsWindow: function(){
			var ajaxCall = 'jaxcontestant.call_contestants("contestants", "register", "ajaxShowTnc", "")';
			cWindowShow(ajaxCall, this.windowTitle , 600, 350);
		},
		authenticate: function(){
			//alert('i am here');
			jaxcontestant.call_contestants("candidates", "registration", "registration.ajaxGenerateAuthKey", "");
		},
		authenticateAssign: function(){
			jaxcontestant.call_contestants("contestants", "register", "ajaxAssignAuthKey");
		},
		assignAuthKey: function(fname, lblname, authkey){
			eval("document.forms['" + fname + "'].elements['" + lblname + "'].value = '" + authkey + "';");
		},
		showWarning: function(message) {
			cWindowShow('jQuery(\'#cWindowContent\').html(\''+message+'\')' , 'Notice' , 450 , 200 , 'warning');
		}
	},
	comments:{
		add: function(id){
			var cmt = jQuery('#'+ id +' textarea').val();
			if(cmt != '') {
				jQuery('#'+ id +' .wall-coc-form-action.add').attr('disabled', true);
				if(typeof getCacheId == 'function')
				{
					cache_id = getCacheId();
				}
				else
				{
					cache_id = "";
				}
				jax.call("community", "plugins,walls,ajaxAddComment", id, cmt, cache_id);
			}
		},
		insert: function(id, text){
			jQuery('#'+ id +' form').before(text);
			mm.comments.cancel(id);
		},
		remove: function(obj){
			var cmtDiv = jQuery(obj).parents('.wallcmt');
			var index  = jQuery(obj).parents('.wallcmt').parent().children().index(cmtDiv);
			try{ console.log(index); } catch(err){}
			var parentId = jQuery(obj).parents('.wallcmt').parent().attr('id');
			try{ console.log(parentId); } catch(err){}
			//jQuery(obj).parent('.wallcmt').remove();

			jax.call("community", "plugins,walls,ajaxRemoveComment", parentId, index);
		},
		cancel: function(id){
			jQuery('#'+ id +' textarea').val('');
			jQuery('#'+ id +' form').hide();
			jQuery('#'+ id +' .show-cmt').show();
			jQuery('#'+ id + ' .wall-coc-errors').hide();
		},
		show: function(id){
			var w = jQuery('#'+ id +' form').parent().width();

			jQuery('#'+ id +' .wall-coc-form-action.add').attr('disabled', false);
			jQuery('#'+ id +' form').width(w).show();
			jQuery('#'+ id +' .show-cmt').hide();

			var textarea = jQuery('#'+ id +' textarea');
			mm.utils.textAreaWidth(textarea);
			mm.utils.autogrow(textarea);

			textarea.blur(function(){
				if (jQuery(this).val()=='') mm.comments.cancel(id);
			});
		}
	},
	utils: {
		// Resize the width of the giventext to follow the innerWidth of
		// another DOM object
		// The textarea must be visible
		textAreaWidth: function(target) {
			with (jQuery(target))
			{
				css('width', '456px');
				css('height', '54px');
				// Google Chrome doesn't return correct outerWidth() else things would be nicer.
				// css('width', width()*2 - outerWidth(true));
				css('width', width() - parseInt(css('borderLeftWidth'))
				                     - parseInt(css('borderRightWidth'))
				                     - parseInt(css('padding-left'))
				                     - parseInt(css('padding-right')));
			}
		},

		autogrow: function (id, options) {

			//alert(id);
			if (options==undefined)
				options = {};

			// In JomSocial, by default every autogrow element will have a 300 maxHeight.
			options.maxHeight = options.maxHeight || 300;

			jQuery(id).autogrow(options);
		}
	},
	connect: {
	    checkRealname: function( value ){
	        var tmpLoadingFunction  = jax.loadingFunction;
			jax.loadingFunction = function(){};
			jax.doneLoadingFunction = function(){ jax.loadingFunction = tmpLoadingFunction; };
			jax.call('community','connect,ajaxCheckName', value);
		},
	    checkEmail: function( value ){
	        var tmpLoadingFunction  = jax.loadingFunction;
			jax.loadingFunction = function(){};
			jax.doneLoadingFunction = function(){ jax.loadingFunction = tmpLoadingFunction; };
			jax.call('community','connect,ajaxCheckEmail', value);
		},
		checkUsername: function( value ){
	        var tmpLoadingFunction  = jax.loadingFunction;
			jax.loadingFunction = function(){};
			jax.doneLoadingFunction = function(){ jax.loadingFunction = tmpLoadingFunction; };
		    jax.call('community','connect,ajaxCheckUsername', value);
		},
		// Displays popup that requires user to update their details upon
		update: function(){
			var ajaxCall = "jax.call('community', 'connect,ajaxUpdate' );";
			cWindowShow(ajaxCall, '', 450, 200);
		},
		updateEmail: function(){
		    jQuery('#facebook-email-update').submit();
		},
		importData: function(){
		    var importStatus    = jQuery('#importstatus').is(':checked') ? 1 : 0;
		    var importAvatar    = jQuery('#importavatar').is(':checked') ? 1 : 0 ;
		    jax.call('community','connect,ajaxImportData',  importStatus , importAvatar );
		},
		mergeNotice: function(){
			var ajaxCall = "jax.call('community','connect,ajaxMergeNotice');";
			cWindowShow(ajaxCall, '', 450, 200);
		},
		merge: function(){
			var ajaxCall = "jax.call('community','connect,ajaxMerge');";
			cWindowShow(ajaxCall, '', 450, 200);
		},
		validateUser: function(){
			// Validate existing user
			var ajaxCall = "jax.call('community','connect,ajaxValidateLogin','" + jQuery('#existingusername').val() + "','" + jQuery('#existingpassword').val() + "');";
			cWindowShow(ajaxCall, '', 450, 200);
		},
		newUser: function(){
			var ajaxCall = "jax.call('community','connect,ajaxShowNewUserForm');";
			cWindowShow(ajaxCall, '', 450, 200);
		},
		existingUser: function(){
			var ajaxCall = "jax.call('community','connect,ajaxShowExistingUserForm');";
			cWindowShow(ajaxCall, '', 450, 200);
		},
		selectType: function(){
			if(jQuery('[name=membertype]:checked').val() == '1' )
			{
				mm.connect.newUser();
			}
			else
			{
				mm.connect.existingUser();
			}
		},
		validateNewAccount: function(){
			// Check for errors on the forms.
			jax.call('community','connect,ajaxCheckEmail', jQuery('#newemail').val() );
			jax.call('community','connect,ajaxCheckUsername', jQuery('#newusername').val() );
			jax.call('community','connect,ajaxCheckName', jQuery('#newname').val() );

			var isValid	= true;
			if(jQuery('#newname').val() == "" || jQuery('#error-newname').css('display') != 'none')
			{
				isValid = false;
			}

			if(jQuery('#newusername').val() == "" || jQuery('#error-newusername').css('display') != 'none')
			{
				isValid = false;
			}

			if(jQuery('#newemail').val() == '' || jQuery('#error-newemail').css('display') != 'none' )
			{
				isValid = false;
			}

			if(isValid)
			{
				var ajaxCall = "jax.call('community', 'connect,ajaxCreateNewAccount' , '" + jQuery('#newname').val() + "', '" + jQuery('#newusername').val() + "','" + jQuery('#newemail').val() + "');";
				cWindowShow(ajaxCall, '', 450, 200);
			}
		}
	},

	// Video component
	videos: {
		showEditWindow: function(id , redirectUrl ){

			if( typeof redirectUrl == 'undefined' )
				redirectUrl	= '';

			var ajaxCall = "jax.call('community', 'videos,ajaxEditVideo', '"+id+"' , '" + redirectUrl + "');";
			cWindowShow(ajaxCall, '' , 450, 400);
		},
		deleteVideo: function(videoId){
			var ajaxCall = "jax.call('community' , 'videos,ajaxRemoveVideo', '" + videoId + "','myvideos');";
			cWindowShow(ajaxCall, '', 450, 150);
		},
		playerConf: {
			// Default flowplayer configuration here
		},
		addVideo: function(creatortype, groupid) {
			//alert('add Video!');
			if(typeof creatortype == "undefined" || creatortype == "")
			{
				var creatortype="";
				var groupid = "";
			}
			var ajaxCall = "jaxcontestant.call_contestants('contestants', 'videos', 'ajaxAddVideo', '" + creatortype + "', '" + groupid + "');";
			//alert(ajaxCall);
			cWindowShow(ajaxCall, '', 450, 350);
		},
		linkVideo: function(creatortype, groupid) {
			var ajaxCall = "jaxcontestant.call_contestants('contestants', 'videos', 'ajaxLinkVideo', '" + creatortype + "', '" + groupid + "');";
			cWindowShow(ajaxCall, '', 450, 100);
		},
		uploadVideo: function(creatortype, groupid) {
			var ajaxCall = "jaxcontestant.call_contestants('contestants', 'videos', 'ajaxUploadVideo', '" + creatortype + "', '" + groupid + "');";
			cWindowShow(ajaxCall, '', 450, 100);
		},
		submitLinkVideo: function() {
			var isValid = true;

			videoLinkUrl = "#linkVideo input[name='videoLinkUrl']";
			if(jQuery.trim(jQuery(videoLinkUrl).val())=='')
			{
				jQuery(videoLinkUrl).addClass('invalid');
				isValid = false;
			}
			else
			{
				jQuery(videoLinkUrl).removeClass('invalid');
			}

			if (isValid)
			{
				jQuery('#cwin-wait').css("margin-left","20px");
				jQuery('#cwin-wait').show();

				document.linkVideo.submit();
			}
		},
		submitUploadVideo: function() {
			var isValid = true;

			videoFile = "#uploadVideo input[name='videoFile']";

			if(jQuery.trim(jQuery(videoFile).val())=='')
			{
				jQuery(videoFile).addClass('invalid');
				isValid = false;
			}
			else
			{
				jQuery(videoFile).removeClass('invalid');
			}

			videoTitle = "#uploadVideo input[name='title']";
			if(jQuery.trim(jQuery(videoTitle).val())=='')
			{
				jQuery(videoTitle).addClass('invalid');
				isValid = false;
			}
			else
			{
				jQuery(videoTitle).removeClass('invalid');
			}

			if (isValid)
			{
				jQuery('#cwin-wait').css("margin-left","20px");
				jQuery('#cwin-wait').show();

				document.uploadVideo.submit();
			}
		},
		fetchThumbnail: function(videoId){
			var ajaxCall = "jax.call('community' , 'videos,ajaxFetchThumbnail', '" + videoId + "','myvideos');";
			cWindowShow(ajaxCall, '', 450, 150);
		}
	},
	users: {
		blockUser: function( userId , isBlocked ){
			var ajaxCall = "jax.call('community', 'profile,ajaxBlockUser', '" + userId + "' , '" + isBlocked + "');";
			cWindowShow(ajaxCall, '', 450, 100);
		},
		removePicture: function( userId ){
			var ajaxCall = "jax.call('community', 'profile,ajaxRemovePicture', '" + userId + "');";
			cWindowShow(ajaxCall, '', 450, 100);
		},
		removeCandidate: function( userId ){
			var ajaxCall = "jax.call('community', 'profile,ajaxRemoveCandidate', '" + userId + "');";
			cWindowShow(ajaxCall, '', 450, 100);
		},
		removeContestant: function( userId ){
			var ajaxCall = "jax.call('community', 'candidates,ajaxRemoveContestant', '" + userId + "');";
			cWindowShow(ajaxCall, '', 450, 100);
		}
	},
	candidates: {
		add: function( userId ){
			var ajaxCall = "jax.call('community', 'candidates,ajaxActiveCandidate', '" + userId + "');";
			cWindowShow(ajaxCall, '', 450, 200);
		},
		activeCandidadate: function( userId ){
			var ajaxCall = 'jaxcontestant.call_contestants("contestants", "register", "ajaxActiveCan", "' + userId + '")';
			cWindowShow(ajaxCall, '', 550, 300);
		},
		activeCandidadateSubmit: function() {
			document.candidateActive.submit();
		},
		candidateListSubmit: function() {
			//alert('ddd');
			document.conForm.submit();
		}
	},
	user: {
		getActive: function( ){
			// return the current active user
			return js_profileId;
		}
	},
	voting: {
		loadComposeWindow: function(userId, ownerId){
			//alert(userId);
			//alert(ownerId);
			if( ownerId > 0 ){
				var ajaxCall = 'jaxcontestant.call_contestants("contestants", "voting", "ajaxCompose", "' + userId + '")';
			}else{
				var ajaxCall = 'jaxcontestant.call_contestants("contestants", "voting", "ajaxLoginAlert", "' + userId + '")';
				//var ajaxCall = "jaxcontestant.call_contestants('contestants', 'voting', 'ajaxLoginAlert', '" + userId + "');
			}
			cWindowShow(ajaxCall, '', 450, 120);
		},
		loadAlertLoginWindow: function(canID){
			var ajaxCall = "jaxcontestant.call_contestants('contestants', 'voting', 'ajaxLoginAlert', '" + canID + "');";
			cWindowShow(ajaxCall, '', 450, 100);
		},
		changeVoteNumber: function(userId){
			jaxcontestant.call_contestants('contestants', 'voting','changeVoteNumber', userId, jQuery('#uservotenumber').val());
		}

	},
	credits: {
		addCredits: function(userId){
			//alert(userId);
			paycode = jQuery('#paycode_id').val();
			//alert(paycode);
			jaxcontestant.call_contestants('contestants', 'register','ajaxAddCredits', paycode, userId);
		},
		creditGiftForm: function(userId){
			//alert(userId);
			var ajaxCall = 'jaxcontestant.call_contestants("contestants", "register", "ajaxCreditGift", "' + userId + '")';
			cWindowShow(ajaxCall, 'Give a Gift' , 400, 200);
		}
	},
	activesms:{
		activeform: function(userId){
			var ajaxCall = 'jaxcontestant.call_contestants("contestants", "register", "activeSms", "' + userId + '")';
			cWindowShow(ajaxCall, 'Kích hoạt hồ sơ' , 400, 200);
		},
		reactiveform: function(userId){
			var ajaxCall = 'jaxcontestant.call_contestants("contestants", "register", "reactiveSms", "' + userId + '")';
			cWindowShow(ajaxCall, 'Đăng Ký Tham Gia CT TOP MODEL' , 400, 170);
		},
		activecandidate: function(userId){
			paycode = jQuery('#paycode_id').val();
			jaxcontestant.call_contestants('contestants', 'register','ajaxActiveCandidate', paycode, userId);
		},
		reactivecandidate: function(userId){
			paycode = jQuery('#paycode_id').val();
			jaxcontestant.call_contestants('contestants', 'register','ajaxReActiveCandidate', paycode, userId);
		},


		tooltiphelp: function(){
			if(jQuery('#tooltiphelp').data('qtip') != null){
				jQuery("#tooltiphelp").qtip({
				   content: 'Presets, presets and more presets. Let\'s spice it up a little with our own style!',
				   style: {
				      width: 200,
				      padding: 5,
				      background: '#A2D959',
				      color: 'black',
				      textAlign: 'center',
				      border: {
				         width: 7,
				         radius: 5,
				         color: '#A2D959'
				      },
				      tip: 'bottomLeft',
				      name: 'dark' // Inherit the rest of the attributes from the preset dark style
				   }
				});
			}
		}
	},
	activemodelonline: {
		activeform: function(userId){
			var ajaxCall = 'jaxcontestant.call_contestants("contestants", "register", "activeModelOnline", "' + userId + '")';
			cWindowShow(ajaxCall, 'Tham Gia Model Online' , 400, 130);
		},
		activeModelPhotoSubmit: function(userId){
			document.ModelOnlineActive.submit();
			//alert(userId);
			//jaxcontestant.call_contestants('contestants', 'register','ajaxActiveModelOnline', userId);
		}
	},
	newtooltip:{
		setup: function(){
			jQuery('#votetooltip').poshytip({
			className: 'tip-darkgray',
			content: '<div class="tooltip_content">Click vào đây để bình chọn cho ứng viên mà bạn yêu thích nhất<br/> <strong style="color:red"><u>Ghi Chú:</u></strong><i>Bạn có thể bình chọn nhiều ứng viên trong ngày và chỉ bình chọn cho một ứng viên 1 lần/ngày mà thôi</i></div>',
			showTimeout: 500,
			hideTimeout: 500,
			alignTo: 'cursor',
			alignX: 'right',
			alignY: 'top',
			offsetY: 40,
			offsetX: -70,
			allowTipHover: true,
			fade: true,
			slide: false
		})
	  }
	},
	tooltip: {
		setup: function( ){
			// Hide all active visible qTip
			jQuery('.qtip-active').hide();
			setTimeout('jQuery(\'.qtip-active\').hide()', 150);
			//try{ clearTimeout(jQuery.fn.qtip.timers.show); } catch(e){}

			// Scan the document and setup the tooltip that has .jomTips
			jQuery(".conTips").each(function(){
				//alert('contips here');
		    	var tipStyle = 'tipNormal';
		    	var tipWidth = 220;
		    	var tipPos	 = {corner: {target: 'topMiddle',tooltip: 'bottomMiddle'}}
		    	var tipShow  = true;
		    	var tipHide	 = { when: { event: 'mouseout' }, effect: { length: 10 } }

		    	if(jQuery(this).hasClass('tipRight'))
				{
					//alert('nghe');
					//alert('tipRight');
		    		tipStyle = 'tipRight';
		    		tipWidth = 220;
		    		tipPos	 = {corner: {target: 'rightTop',tooltip: 'leftBottom'}}
		    	}
		    	var title = '';
		    	var content = jQuery(this).attr('title');
				var contentArray = content.split('::');

				//alert(content);

				// Remove the 'title' attributes from the existing .jomTips classes
				jQuery( this ).attr('title' , '' );

				if(contentArray.length == 2)
				{
					content = contentArray[1];
					title = { text: contentArray[0] } ;
				} else
					title = title = { text: '' } ; ;

				//title='this is a title';
				//tipPos='topMiddle';
				//alert(tipPos);
		    	jQuery(this).qtip({
		    		content: {
					   text: content,
					   title: title
					},
					style: {name:'dark', width: tipWidth,  padding: 2, margin: 2},
					position: tipPos,
					hide: tipHide,
					tip: true,
					show: { solo: true, effect: { length: 50 } }
			 	}).removeClass('conTips');
			});

			return true;
		},

		setStyle: function() {
			jQuery.qtip.styles.tipNormal = { // Last part is the name of the style
				width: 220,
				border: {
					width: 7,
					radius: 5
				},
				tip: true,
				name: 'dark' // Inherit the rest of the attributes from the preset dark style
			}

			jQuery.fn.qtip.styles.tipRight = { // Last part is the name of the style
				tip: 'leftMiddle',
				name: 'tipNormal' // Inherit the rest of the attributes from the preset dark style
			}

			return true;
		}
	}
}

// close layer when click-out
jQuery(document).click( function() {
    mm.toolbar.close();
});

// Document ready
jQuery(document).ready(function () {

	//alert('ready!');
	//mm.tooltip.setStyle();
	mm.tooltip.setup();
	//mm.newtooltip

});

(function(jQuery) {
    jQuery.fn.autogrow = function(options) {

        this.filter('textarea').each(function() {

			var textarea = jQuery(this);

			// Hide scrollbar first.
			textarea.css('overflow','hidden');

			options.minHeight = options.minHeight || textarea.height();
			options.maxHeight = options.maxHeight || 0;

            textarea.siblings('.textarea-shadow').remove();
            var shadow = jQuery('<div class="textarea-shadow">').css({
                             'position'    : 'absolute',
                             'visibility'  : 'hidden',
                             'font-size'   : (textarea[0].currentStyle==undefined) ? textarea.css('font-size') : textarea[0].currentStyle.fontSize,
                             'font-family' : textarea.css('font-family'),
                             'line-height' : textarea.css('line-height'),
                             'width'       : textarea.width()
                         }).insertBefore(textarea);

			var timer;
            var update = function() {
                var times = function(string, number) {
                    var _res = '';
                    for(var i=0; i<number; i++) {
                        _res = _res + string;
                    }
                    return _res;
                };

                var val = textarea[0].value.replace(/</g, '&lt;')
                                     .replace(/>/g, '&gt;')
                                     .replace(/&/g, '&amp;')
                                     .replace(/\njQuery/, '<br/>&nbsp;')
                                     .replace(/\n/g, '<br/>')
                                     .replace(/ {2,}/g, function(space) { return times('&nbsp;', space.length -1) + ' ' });
                shadow.html(val);

                // Resize textarea if maxHeight is not reached
                var newHeight = Math.max(shadow.height() + 20, options.minHeight);
				if(newHeight < options.maxHeight || options.maxHeight==0)
				{
					textarea.css({'height'   : newHeight,
					              'overflow' : 'hidden'
					             });
				// Enable scrollbar if maxHeight is reached.
				} else {
                	textarea.css('overflow','auto');
				}

                clearTimeout(timer);
            }

            var checkExpand = function() {
            	timer = setTimeout(update, 100);
            }

            textarea.change(checkExpand).keydown(checkExpand).keyup(checkExpand);

            update.apply(this);
        });

        return this;

    }

})(jQuery);
