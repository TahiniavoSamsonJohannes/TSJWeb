$(document).ready(function(){
    $(document).on('click', '.member', function(){
        window.selectedMemberId = $(this).data('member-id');
        $('.toUser').load('actions/MemberAction.php', { memberId: window.selectedMemberId });
    });

});
