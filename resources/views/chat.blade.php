@extends('layout')

@section('content')
    <div class="overflow-visible">
        <nav class="navbar bg-body-tertiary shadow fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">ChatGPT</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar"
                    aria-labelledby="sideNavbar">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="sideNavbar">ChatGPT</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <li class="rounded-2 px-2 py-1 mb-2 d-flex justify-content-center">
                            <button type="button" class="btn btn-outline-light">
                                <i class="bi bi-plus-lg"></i> New Chat
                            </button>
                        </li>
                        <ul class="p-0 chat-list">
                            <li class="rounded-2 px-2 py-1 d-flex justify-content-between align-items-center bg-body-tertiary">
                                <div>An item</div>
                                <div>
                                    <button type="button" class="btn btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm text-danger">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </li>
                            <li class="rounded-2 px-2 py-1 d-flex justify-content-between align-items-center">
                                <div>An item</div>
                                <div>
                                    <button type="button" class="btn btn-sm my-1">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm my-1">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </li>
                            <li class="rounded-2 px-2 py-1 d-flex justify-content-between align-items-center">
                                <div>An item</div>
                                <div>
                                    <button type="button" class="btn btn-sm my-1">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm my-1">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </li>
                            <li class="rounded-2 px-2 py-1 d-flex justify-content-between align-items-center">
                                <div>An item</div>
                                <div>
                                    <button type="button" class="btn btn-sm my-1">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm my-1">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <main class="container-fluid overflow-y-scroll">
            <div>
                <div class="rounded-5 p-3 mx-2 my-3 bg-body-tertiary float-end" style="max-width: 70%">To control the border and
                    outline, the CSS property is used. To remove the focus border (outline) from text/input boxes, the
                    outline and border property is used. Remove Focus Border/Outline Around TextArea The CSS property
                    outline: none; and border:none; within the :focus selector to remove the outline of input textarea. This
                    prevents the default outline from appearing when the text box is clicked or focused.</div>
                <br>
                <div class="p-3 mx-2 my-3 float-start">To control the border and outline, the CSS property is used. To remove the
                    focus border (outline) from text/input boxes, the outline and border property is used. Remove Focus
                    Border/Outline Around TextArea The CSS property outline: none; and border:none; within the :focus
                    selector to remove the outline of input textarea. This prevents the default outline from appearing when
                    the text box is clicked or focused.</div>
                <br>
                <div class="rounded-5 p-3 mx-2 my-3 bg-body-tertiary float-end" style="max-width: 70%">T111</div>
                <div class="p-3 mx-2 my-3 float-start">To control the border and outline, the CSS property is used. To remove the
                    focus border (outline) from text/input boxes, the outline and border property is used. Remove Focus
                    Border/Outline Around TextArea The CSS property outline: none; and border:none; within the :focus
                    selector to remove the outline of input textarea. This prevents the default outline from appearing when
                    the text box is clicked or focused.</div>
                <br>
                <div class="rounded-5 p-3 mx-2 my-3 bg-body-tertiary float-end" style="max-width: 70%">To control the border and
                    outline, the CSS property is used. To remove the focus border (outline) from text/input boxes, the
                    outline and border property is used. Remove Focus Border/Outline Around TextArea The CSS property
                    outline: none; and border:none; within the :focus selector to remove the outline of input textarea. This
                    prevents the default outline from appearing when the text box is clicked or focused.</div>
                <br>
                <div class="p-3 mx-2 my-3 float-start">To control the border and outline, the CSS property is used. To remove the
                    focus border (outline) from text/input boxes, the outline and border property is used. Remove Focus
                    Border/Outline Around TextArea The CSS property outline: none; and border:none; within the :focus
                    selector to remove the outline of input textarea. This prevents the default outline from appearing when
                    the text box is clicked or focused.</div>
                <br>
                <div class="rounded-5 p-3 mx-2 my-3 bg-body-tertiary float-end" style="max-width: 70%">To control the border and
                    outline, the CSS property is used. To remove the focus border (outline) from text/input boxes, the
                    outline and border property is used. Remove Focus Border/Outline Around TextArea The CSS property
                    outline: none; and border:none; within the :focus selector to remove the outline of input textarea. This
                    prevents the default outline from appearing when the text box is clicked or focused.</div>
                <br>
            </div>
        </main>
        <div class="m-2 fixed-bottom rounded-5 bg-body-tertiary p-2">
            <form>
                <div class="d-flex justify-content-between align-items-center">
                    <textarea type="text" class="form-control bg-body-tertiary" id="exampleFormControlInput1" style="resize:none"
                        placeholder="Message ChatGPT"></textarea>
                    <button type="button" class="btn btn-outline-secondary mx-2"><i class="bi bi-send-fill"></i></button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(async () => {
            const top = document.querySelector(".fixed-top").offsetHeight;
            const bottom = document.querySelector(".fixed-bottom").offsetHeight;
            document.querySelector("main").style.height = `calc(100vh - ${top + bottom}px)`
            document.querySelector("main").style.marginTop = `${top}px`

            // var last_response = false;
            // $.ajax(`${location.origin}/stream`, {
            //         xhrFields: {
            //             onprogress: function(e) {
            //                 var this_response, response = e.currentTarget.response;
            //                 if (last_response.length === false) {
            //                     this_response = response;
            //                 } else {
            //                     this_response = response.substring(last_response.length);
            //                 }
            //                 last_response = response;
            //                 console.log(this_response);
            //             }
            //         }
            //     })
            //     .done(function(data) {
            //         console.log('Complete response = ' + data);
            //     })
            //     .fail(function(data) {
            //         console.log('Error: ', data);
            //     });

            // const xhr = new XMLHttpRequest();
            // xhr.open('GET', `${location.origin}/stream`, true);

            // xhr.onreadystatechange = function() {
            //     if (xhr.readyState === 3) {
            //         const response = xhr.responseText;
            //         console.log(xhr.responseText);
            //     }
            // };

            // xhr.onload = function() {
            //     if (xhr.status === 200) {
            //         console.log("Streaming complete");
            //     } else {
            //         console.error("Error:", xhr.statusText);
            //     }
            // };

            // xhr.onerror = function() {
            //     console.error("Request failed");
            // };

            // xhr.send();

        });
    </script>
@endsection
