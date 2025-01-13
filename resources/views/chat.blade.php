@extends('layout')

@section('content')
    <div class="overflow-visible">
        <nav class="navbar bg-body-tertiary shadow fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">{{ env('APP_NAME') }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="sideNavbar">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="sideNavbar">{{ env('APP_NAME') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <div class="d-flex justify-content-center px-2 py-1 mb-2">
                            <button type="button" class="btn btn-outline-light" id="new-chat-btn">
                                <i class="bi bi-plus-lg"></i> New Chat
                            </button>
                        </div>
                        <ul class="p-0 chat-group">
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <main class="container-fluid overflow-y-scroll overflow-x-hidden" id="chat-content">
        </main>
        <div class="m-2 fixed-bottom rounded-5 bg-body-tertiary p-2">
            <form>
                <div class="d-flex justify-content-between align-items-center">
                    <textarea type="text" class="form-control bg-body-tertiary" id="send-message" style="resize:none"
                        placeholder="Message {{ env('APP_NAME') }}"></textarea>
                    <button type="button" class="btn btn-outline-secondary mx-2" id="send"><i
                            class="bi bi-send-fill"></i></button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(() => {
            // set message content style
            const top = $(".fixed-top").outerHeight();
            const bottom = $(".fixed-bottom").outerHeight();
            $("main").css({
                "height": `calc(100vh - ${top + bottom}px)`,
                "margin-top": `${top}px`
            })

            // new chat button action
            $("#new-chat-btn").on("click", () => {
                $("#chat-content").empty();
                $(".btn-close").click();
                sessionStorage.setItem("chat-id", "");
                if ($(".chat-group .bg-body-tertiary"))
                    $(".chat-group .bg-body-tertiary").removeClass("bg-body-tertiary")
            })

            // Notification
            const Notification = (msg, type = "danger") => {
                const msgContent =
                    `<div class="alert alert-${type}" role="alert">${msg}</div>`;
                $("#notify-messages").append(msgContent)

                setTimeout(() => {
                    $("#notify-messages").html($("#notify-messages").html()
                        .replace(msgContent, ""))
                }, 5000);
            }

            // send and get message
            $("#send").on("click", (ele) => {
                ele.stopPropagation();
                $("#send").attr("disabled", 1)

                let sessId = sessionStorage.getItem("chat-id")
                let message = $("#send-message").val();

                // check message length
                if (message.length > 120) {
                    Notification("Must be less than 120 characters.");
                    $("#send").attr("disabled", false)
                } else {

                    // append user message in body content
                    $("#chat-content").append(
                        `<div class="rounded-5 p-3 mx-2 my-3 bg-body-tertiary float-end user-message" style="max-width: 70%">${message}</div><br>`
                    )

                    // check and create chat group
                    if (!sessId) {
                        $.post(`${location.origin}/api/chat_group/create`, {
                            name: message
                        }).done((res) => {
                            sessionStorage.setItem("chat-id", res.data);
                            sessId = res.data;
                            chatGeneration();
                            getChatGroups();
                        })
                    } else {
                        chatGeneration();
                    }
                }

                // stream chat api
                function chatGeneration() {
                    var last_response = false;
                    $("#send-message").val("");
                    $.ajax(`${location.origin}/api/stream_chat`, {
                            type: "POST",
                            data: {
                                group_id: sessId,
                                message: message
                            },
                            xhrFields: {
                                // get stream content
                                onprogress: function(e) {
                                    var this_response, response = e.currentTarget.response;

                                    // check server error
                                    if (response.indexOf("#Error: Something went wrong#") >= 0) {
                                        Notification("Something went wrong.");
                                        $("#send").attr("disabled", false)
                                        $("#send-message").val(message);

                                        // Remove error chat
                                        // $("#chat-content .user-message").last().remove();
                                        // if (last_response !== false) {
                                        //     $("#chat-content .user-message").last().remove();
                                        // }
                                    } else {

                                        // append response in body content
                                        if (last_response === false) {
                                            let userMessage = response
                                                .replaceAll("\n", "<br>")

                                            $("#chat-content").append(
                                                `<div class="p-3 mx-2 my-3 float-start w-100 reply-message">${userMessage}</div><br>`
                                            )
                                            $("#chat-content").animate({
                                                scrollTop: document.querySelector(
                                                        '#chat-content').scrollHeight +
                                                    100
                                            }, 100);
                                        } else {
                                            this_response = response.substring(last_response
                                                .length);

                                            let systemMessage = this_response
                                                .replaceAll("\n", "<br>")
                                            $("#chat-content .reply-message").last().append(
                                                systemMessage);
                                        }

                                        last_response = response;
                                        // console.log(response);
                                    }
                                }
                            }
                        })
                        .done(function(data) {
                            $("#send").attr("disabled", false)
                        })
                        .fail(function(data) {
                            console.log('Error: ', data);
                            $("#send").attr("disabled", false)
                            $("#send-message").val(message);
                        });
                }
            })

            // get chats
            const getChats = () => {
                let sessId = sessionStorage.getItem("chat-id")
                if (sessId) {
                    $.get(`${location.origin}/api/chats/${sessId}`).done((res) => {
                        if (res.code == 0) {

                            // fetch chat content
                            res.data.forEach(item => {
                                if (item.role == "user") {
                                    $("#chat-content").append(
                                        `<div class="rounded-5 p-3 mx-2 my-3 bg-body-tertiary float-end user-message" style="max-width: 70%">${item.message}</div><br>`
                                    )
                                } else {
                                    let message = item.message
                                        .replace(/^### (.*$)/gim, '<h3>$1</h3>') // h3 tag
                                        .replace(/^## (.*$)/gim, '<h2>$1</h2>') // h2 tag
                                        .replace(/^# (.*$)/gim, '<h1>$1</h1>') // h1 tag
                                        .replace(/\*\*(.*)\*\*/gim, '<b>$1</b>') // bold text
                                        .replace(/\*(.*)\*/gim, '<i>$1</i>')
                                        .replaceAll("\n", "<br>")
                                    $("#chat-content").append(
                                        `<div class="p-3 mx-2 my-3 float-start w-100 reply-message">${message}</div><br>`
                                    )
                                }
                            })
                            $("#chat-content").animate({
                                scrollTop: document.querySelector('#chat-content')
                                    .scrollHeight + 100
                            }, 1);
                        }
                    })
                }
            }

            getChats();

            const getChatGroups = () => {
                $.get(`${location.origin}/api/chat_groups`).done((res) => {
                    if (res.code == 0) {
                        $(".chat-group").empty();
                        res.data.forEach(item => {
                            $(".chat-group").append(
                                `<li class="rounded-2 px-2 py-1 d-flex justify-content-between align-items-center" data-id="${item.id}">
                                        <p class="m-0 chat-group-name">${item.name}</p>
                                        <button type="button" class="btn btn-sm edit-group">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm text-danger delete-group">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </li>`)
                        })

                        // reset active menu
                        const resetActiveMenu = () => {
                            let sessId = sessionStorage.getItem("chat-id")

                            $(".chat-group").children().each(function() {
                                if ($(this).data("id") == sessId)
                                    $(this).addClass("bg-body-tertiary")
                                else
                                    $(this).removeClass("bg-body-tertiary")
                            })
                        }
                        resetActiveMenu();

                        // menu click action
                        $(".chat-group li").each(function() {
                            $(this).click(function(ele) {
                                ele.stopPropagation();

                                let id = $(this).data("id");
                                sessionStorage.setItem("chat-id", id);
                                $("#chat-content").empty();
                                getChats();
                                resetActiveMenu();
                                $(".btn-close").click();
                            })
                        })

                        // chat group edit action
                        $(".edit-group").each(function() {
                            $(this).click(function(ele) {
                                ele.stopPropagation();
                                ele.preventDefault();

                                let parentEle = $(this).parent();
                                let id = parentEle.data("id");
                                let oldName = parentEle.children("p").text();
                                let name = prompt("Enter Name", oldName);

                                if (name && id) {

                                    // check name length
                                    if (name.length > 120) {
                                        Notification(
                                            "Must be less than 120 characters.");
                                        $(".btn-close").click();
                                    } else {
                                        $.post(`${location.origin}/api/chat_group/update/${id}`, {
                                            name
                                        }).done((res) => {
                                            sessionStorage.setItem(
                                                "chat-id",
                                                res.data);
                                            sessId = res.data;
                                            getChatGroups();
                                        })
                                    }
                                }
                            })
                        })

                        // chat group delete action
                        $(".delete-group").each(function() {
                            $(this).click(function(ele) {
                                ele.stopPropagation();
                                ele.preventDefault();

                                let id = $(this).parent().data("id");
                                let deleteData = confirm("Are you sure to delete?")
                                if (deleteData && id) {

                                    $.get(
                                            `${location.origin}/api/chat_group/delete/${id}`
                                        )
                                        .done((res) => {
                                            let sessId = sessionStorage.getItem(
                                                "chat-id")
                                            if (id == sessId) {
                                                $("#chat-content").empty();
                                                $(".btn-close").click();
                                                sessionStorage.setItem(
                                                    "chat-id", "");
                                            }
                                            getChatGroups();
                                        })
                                }
                            })
                        })
                    }
                })
            }

            getChatGroups();
        });
    </script>
@endsection
