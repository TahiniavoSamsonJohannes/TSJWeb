$(document).ready(function(){
    $(document).on('click', '.member', function(){
        window.selectedMemberId = $(this).data('member-id');
        $('.messages').load('AllMessages.php', { memberId: window.selectedMemberId });
        $('.toUser').load('actions/MemberAction.php', { memberId: window.selectedMemberId });
    });

});