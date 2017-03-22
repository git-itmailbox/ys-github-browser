/**
 * Created by yura on 22.03.17.
 */

$(document).ready(function () {
    $(".unlike").on("click", function () {
        unlikeUser(this);
    });
    $(".like").on("click", function () {
        likeUser(this);
    });

    $(".unlikerepo").on("click", function () {
        unlikeRepo(this);
    });
    $(".likerepo").on("click", function () {
        likeRepo(this);
    });
});

function unlikeUser(e) {
    var githubLoginId = $(e).data("loginid");
    $.post("/main/setulike", {id: githubLoginId, like: 0}, function (data) {
            if (data.state = true) {

                $(e).closest('div').find('.like').toggleClass("hidden");
                $(e).toggleClass("hidden");
            }

        },
        'json');
}
function likeUser(e) {
    var githubLoginId = $(e).data("loginid");
    $.post("/main/setulike", {id: githubLoginId, like: 1}, function (data) {
            if (data.state = true) {
                $(e).closest('div').find('.unlike').toggleClass("hidden");
                $(e).toggleClass("hidden");
            }
        },
        'json');
}

function unlikeRepo(e) {
    var githubRepoId = $(e).data("repoid");
    $.post("/main/setrlike", {id: githubRepoId, like: 0}, function (data) {
            if (data.state = true) {

                $(e).closest('div').find('.likerepo').toggleClass("hidden");
                $(e).toggleClass("hidden");
            }

        },
        'json');
}
function likeRepo(e) {
    var githubRepoId = $(e).data("repoid");
    $.post("/main/setrlike", {id: githubRepoId, like: 1}, function (data) {
            if (data.state = true) {
                $(e).closest('div').find('.unlikerepo').toggleClass("hidden");
                $(e).toggleClass("hidden");
            }
        },
        'json');
}
