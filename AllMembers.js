$(document).ready(function(){
    var searchTimer;
    function searchMembers() {
        var term = $('#member-search').val().trim();
        if (!term) { $('#member-results').empty(); return; }
        $('#member-results').load('AllMembers.php?q=' + encodeURIComponent(term));
    }
    $('#member-search').on('input', function(){ clearTimeout(searchTimer); searchTimer = setTimeout(searchMembers, 220); });
    $(document).on('click', '.member', function(){
        window.selectedMemberId = $(this).data('member-id');
        $('.toUser').load('actions/MemberAction.php', { memberId: window.selectedMemberId });
        $('.chat-layout').addClass('conversation-open');
    });
    $(document).on('click', '.friend-action', function(e){
        e.stopPropagation();
        var button = $(this), term = $('#member-search').val().trim();
        if (button.data('action') === 'remove' && !window.confirm('Remove this friend?')) return;
        $.post('actions/FriendAction.php', {action: button.data('action'), userId: button.data('user-id')})
            .done(function(){
                if (term) $('#member-results').load('AllMembers.php?q=' + encodeURIComponent(term));
                $('#friend-list').load('AllMembers.php?section=friends');
            })
            .fail(function(){ alert('The friend request could not be processed.'); });
    });
});
