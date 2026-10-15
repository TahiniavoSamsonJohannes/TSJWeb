<?php
include('actions/SecurityAction.php');
/* include("actions/insertMessageAction.php"); */


?>

<!DOCTYPE html>
<html lang="en">
    <?php include("head.php"); ?>
<body onLoad="load_focus()">
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
            <div class="toUser">

                <?php include("actions/MemberAction.php"); ?>
                
            </div>

            <div class="messages"></div>

        </div>
        <div class="write-messages">
            <textarea id="textarea" placeholder="Write your message..."></textarea>
            <button id="send">Send</button>
        </div>
    </div>

        <!------------------------- sidebar right ----------------------------->
    <div class="sidebar-right">
        <button class="members members-toggle" type="button" aria-expanded="false" aria-controls="chat-members-list">
            <span>Members</span>
            <span class="members-toggle-icon" aria-hidden="true">&#9662;</span>
        </button>
            <div class="AllMembers" id="chat-members-list">
                <?php include("AllMembers.php"); ?>
            </div>
            
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

                if(message!=""){
                    if(!window.selectedMemberId){
                        return;
                    }

                    $.ajax({
                        url: "actions/insertMessageAction.php",
                        type: "POST",
                        data:{
                            message: message,
                            toUserId: window.selectedMemberId
                        },
                        success: function(){
                            $('#textarea').val('');
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

            $(document).on('click', '.member', function(){
                window.selectedMemberId = $(this).data('member-id');
                loadMessages(true);
            });
        });

        function load_focus(){
            document.getElementById("textarea").focus();
        }

        document.querySelector('.members-toggle').addEventListener('click', function() {
            var isExpanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', String(!isExpanded));
            this.closest('.sidebar-right').classList.toggle('members-list-open', !isExpanded);
        });

    </script>

    
</body>
</html>
