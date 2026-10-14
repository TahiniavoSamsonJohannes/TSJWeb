<?php
include('actions/SecurityAction.php');
/* include("actions/insertMessageAction.php"); */


?>

<!DOCTYPE html>
<html lang="en">
    <?php include("head.php"); ?>
<body onLoad="load_focus()">
    <?php include("navbar.php"); ?>

    <div class="container-body">
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
        <div class="members">
            <img src="images/member.png">
            <span>Members</span>
        </div>
            <div class="AllMembers">
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
                            $('.messages').load('AllMessages.php', { memberId: window.selectedMemberId });
                        },
                        error: function(xhr){
                            console.error('Message insertion failed:', xhr.status, xhr.responseText);
                            alert('The message could not be saved. Check the browser console and server error log.');
                        }
                    });
                }
            });
        });
        
        
        function load_focus(){
            document.getElementById("textarea").focus();
        }
        
        setInterval('load_messages()', 400);
        
        var messages = document.querySelector(".messages");
        
        function load_messages(){
            if(window.selectedMemberId){
                $(".messages").load("AllMessages.php", { memberId: window.selectedMemberId }, function(){
                    messages.scrollTop = messages.scrollHeight;
                });
            }
        }
        

    </script>

    
</body>
</html>