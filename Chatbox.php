<?php
include('actions/SecurityAction.php');
/* include("actions/insertMessageAction.php"); */


?>

<!DOCTYPE html>
<html lang="en">
    <?php include("head.php"); ?>
<body class="chat-page" onLoad="load_focus()">
    <?php include("navbar.php"); ?>

    <div class="container-body chat-layout">
        <!------------------------- sidebar left ----------------------------->
        <div class="sidebar-left">
            <div class="links">
                <img src="images/newspaper.png">
                <a href="#">World News</a>
            </div>
            <div class="links">
                <img src="images/web-development.png">
                <a href="#">Web Development</a>
            </div>
            <div class="links">
                <img src="images/usa-flag.png">
                <a href="#">English Course</a>
            </div>
            <div class="links">
                <img src="images/sports.png">
                <a href="#">Sports</a>
            </div>
            <div class="links">
                <img src="images/videos.png">
                <a href="#">Watch Videos</a>
            </div>

            <a href="#">See more</a>

            <hr/>

            <div class="links">
                <img src="images/carnet.png">
                <a href="#">Notepad</a>
            </div>
        </div>


        <!------------------------- private message ----------------------------->
    <div class="private-message">
        <div class="user-chat">
            <div class="toUser"><span class="chat-placeholder">Choisissez un membre</span></div>

            <div class="messages"></div>

        </div>
        <div class="write-messages">
            <textarea id="textarea" placeholder="Write your message..."></textarea>
            <label class="message-image-picker" id="message-image-button" for="message-image"><img src="images/add-image.png" alt=""><span class="message-image-picker-text">Choose image</span><span id="message-image-name"></span></label>
            <input id="message-image" type="file" accept="image/jpeg,image/png,image/gif,image/webp">
            <button id="send">Send</button>
        </div>
    </div>

        <!------------------------- sidebar right ----------------------------->
    <div class="sidebar-right">
        <div class="AllMembers" id="chat-members-list">
            <div class="member-search-wrap">
                <label class="member-search-label" for="member-search">Search people</label>
                <input id="member-search" type="search" autocomplete="off" placeholder="Type a name..." aria-controls="member-results">
            </div>
            <div id="member-results" aria-live="polite"></div>
            <?php include("AllMembers.php"); ?>
        </div>

    </div>



    <!-- Importation de la librarie jQuery -->
    <script src="jQuery-3.7.js"></script>
    <script src="slide_menu.js"></script>
    <script src="AllMembers.js"></script>
    <script>
        $(document).ready(function(){
            var messages = document.querySelector('.messages');
            var messageRequestInFlight = false;
            var lastMessagesMarkup = null;
            var longPressTimer = null;
            var longPressTarget = null;

            function scrollMessagesToBottom(smooth) {
                messages.scrollTo({
                    top: messages.scrollHeight,
                    behavior: smooth ? 'smooth' : 'auto'
                });
            }

            function loadMessages(forceBottom) {
                if (!window.selectedMemberId || messageRequestInFlight) return;

                var memberId = window.selectedMemberId;
                var wasAtBottom = messages.scrollHeight - messages.clientHeight - messages.scrollTop < 90;
                messageRequestInFlight = true;

                $.ajax({
                    url: 'AllMessages.php',
                    type: 'POST',
                    data: { memberId: memberId },
                    success: function(markup) {
                        if (memberId !== window.selectedMemberId) return;
                        if (markup === lastMessagesMarkup) {
                            if (forceBottom) requestAnimationFrame(function() { scrollMessagesToBottom(true); });
                            return;
                        }
                        lastMessagesMarkup = markup;
                        messages.innerHTML = markup;
                        if (forceBottom || wasAtBottom) {
                            requestAnimationFrame(function() { scrollMessagesToBottom(true); });
                        }
                    },
                    complete: function() {
                        messageRequestInFlight = false;
                        if (memberId !== window.selectedMemberId) loadMessages(true);
                    }
                });
            }

            $('#send').click(function(){
            var message = $('#textarea').val();

                if(message!=="" || document.getElementById('message-image').files.length){
                    if(!window.selectedMemberId){
                        return;
                    }

                    var formData = new FormData();
                    formData.append('message', message);
                    formData.append('toUserId', window.selectedMemberId);
                    var imageFile = document.getElementById('message-image').files[0];
                    if (imageFile) formData.append('message_image', imageFile);
                    $.ajax({
                        url: "actions/insertMessageAction.php",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(){
                            $('#textarea').val('');
                            $('#message-image').val('');
                            document.getElementById('message-image').dispatchEvent(new Event('change'));
                            loadMessages(true);
                        },
                        error: function(xhr){
                            console.error('Message insertion failed:', xhr.status, xhr.responseText);
                            alert('The message could not be saved. Check the browser console or server error log.');
                        }
                    });
                }
            });
            setInterval(function(){ loadMessages(false); }, 1200);
            setInterval(function(){ if(window.selectedMemberId && document.visibilityState==='visible') $('.toUser').load('actions/MemberAction.php',{memberId:window.selectedMemberId}); }, 60000);

            $(document).on('click', '.member', function(){
                window.selectedMemberId = $(this).data('member-id');
                document.querySelector('.chat-layout').classList.add('conversation-open');
                loadMessages(true);
            });
            $(document).on('click', '.chat-back', function(){ document.querySelector('.chat-layout').classList.remove('conversation-open'); });

            function copyBubbleText(bubble) {
                var clone = bubble.cloneNode(true);
                clone.querySelectorAll('img').forEach(function(image) { image.remove(); });
                var text = (clone.innerText || clone.textContent).trim();
                if (!text) return;
                if (navigator.clipboard && window.isSecureContext) navigator.clipboard.writeText(text).catch(function() {});
                else { var input=document.createElement('textarea'); input.value=text; input.style.position='fixed'; input.style.opacity='0'; document.body.appendChild(input); input.select(); try { document.execCommand('copy'); } catch(e) {} input.remove(); }
            }
            $(document).on('touchstart', '.myMessage span, .hisOrherMessage span', function(){
                longPressTarget=this;
                this.classList.add('message-pressing');
                longPressTimer=setTimeout(function(){ if(longPressTarget){ copyBubbleText(longPressTarget); longPressTarget.classList.add('message-copied'); setTimeout(function(){ longPressTarget && longPressTarget.classList.remove('message-copied'); },500); } },500);
            });
            $(document).on('touchend touchmove touchcancel', '.myMessage span, .hisOrherMessage span', function(){ clearTimeout(longPressTimer); this.classList.remove('message-pressing'); longPressTarget=null; });

            var touchStartX=0;
            document.querySelector('.chat-layout').addEventListener('touchstart',function(e){touchStartX=e.changedTouches[0].screenX;},{passive:true});
            document.querySelector('.chat-layout').addEventListener('touchend',function(e){var delta=e.changedTouches[0].screenX-touchStartX;if(delta > 60 && window.selectedMemberId && !this.classList.contains('conversation-open'))this.classList.add('conversation-open');if(delta < -60 && this.classList.contains('conversation-open'))this.classList.remove('conversation-open');},{passive:true});
        });

        function load_focus(){
            document.getElementById("textarea").focus();
        }

        document.getElementById('message-image').addEventListener('change', function () {
            var picker = document.getElementById('message-image-button');
            picker.classList.toggle('has-image', this.files.length > 0);
            document.getElementById('message-image-name').textContent = this.files.length ? this.files[0].name : '';
            document.querySelector('.message-image-picker-text').textContent = this.files.length ? 'Image selected' : 'Choose image';
        });

    </script>

    
</body>
</html>
