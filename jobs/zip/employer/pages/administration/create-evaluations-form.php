<style>
    .fieldContainer {
        border: solid 1px #ccc;
        border-radius: 5px;
        width: 100%;
        margin: 10px;
        overflow: hidden;
    }

    .fieldHeaderContainer {
        padding: 15px;
        background-color: #F9FAFB;
        border: none;
        border-bottom: solid 1px #ccc;
        display: flex !important;
        justify-content: space-between;
    }

    .fieldBodyContainer {
        padding: 15px;
        background-color: #fff;
        border: none;
        border-bottom: solid 1px #ccc;
        display: flex !important;
    }

    .answersContainer {
        padding: 15px;
        background-color: #fff;
        border: none;
        border-bottom: solid 1px #ccc;
    }

    .innerFieldStyle{
        margin-top: 10px;
    }

    .fieldListContainer {
        width: 100%;
        padding: 15px;
    }
</style>

<?php

if (isset($_POST['new-template'])) {
    $Template_name = $_POST['name'];
    $Template_category = $_POST['category'];

    $_SESSION['template_name'] = $Template_name;
    $_SESSION['template_category'] = $Template_category;
}

?>

<div class="content-wrapper">
    <div class="row" style="padding: 20px">

        <div class="col-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>
                        Evaluation forms
                    </h4>
                    <span>Create sets of custom questions to be used during interviews or general evaluations of candidates</span>
                    <div style="margin-top:10px;">
                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#basicModal">Create new template</a>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-6">
                            <h4>
                                <?php
                                if (isset($_SESSION['template_name'])) {
                                    echo $_SESSION['template_name'];
                                } else {
                                    echo 'Template name';
                                }
                                ?>
                            </h4>
                            <span>
                                <?php
                                if (isset($_SESSION['template_category'])) {
                                    echo $_SESSION['template_category'];
                                } else {
                                    echo 'Template category';
                                }
                                ?>
                            </span>
                        </div>
                        <div class="col-6" style="margin-top:10px; display:flex; justify-content: flex-end;">
                            <a href="#" class="btn btn-success" style="height: 35px; margin-right:10px">Save</a>
                            <a href="#" class="btn btn-danger" style="height: 35px;" data-toggle="modal" data-target="#basicModal">Delete</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="height:70vh; overflow:auto;">
                    <form method="post" id="fieldList" class="fieldListContainer">

                    </form>
                    <div>
                        <button id="addbtn" style="width:100%; border: dashed 2px #ccc">
                            + Add new
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">
                            Create new template
                        </h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" class="row g-3">
                            <div class="col-12">
                                <label class="">Template name <span style="color:red; font-size:20px">*</span></label>
                                <input name="name" type="text" required="required" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="">Template category</label>
                                <input name="category" type="text" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" name="new-template" class="btn btn-primary">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<script type="text/javascript" src="../../js/jquery-2.2.4.min.js"></script>

<script>
    var fieldsList = [{
        id: '1234',
        type: 'single_line',
        isRequired: true
    }];

    function addField() {
        // fieldsList
    }

    $('#addbtn').click(function() {

        for (let index = 0; index < fieldsList.length; index++) {
            var id = "id" + Math.random().toString(16).slice(2)
            const element = fieldsList[index];

            var container = document.createElement('div');
            container.classList.add('fieldContainer');
            container.id = id;
            // $('.fieldContainer').addClass('disabled');

            var header = document.createElement('div');
            header.classList.add('fieldHeaderContainer');
            container.appendChild(header);

            var cartHTML = '<div>';
            cartHTML = '<select onchange="getval(this,id);" id="' + id + '" class="form-control" style="width:200px">';
            cartHTML += '<option value="single_line">Text(single line)</option>'
            cartHTML += '<option value="multiple_line">Text(multiple line)</option>'
            cartHTML += '<option value="yes_no">Yes/No</option>'
            cartHTML += '<option value="single_choice">Single Choice</option>'
            cartHTML += '<option value="multiple_choice">Multiple Choice</option>'
            cartHTML += '<option value="drop_down">Drop-down</option>'
            cartHTML += '<option value="rating">Rating</option>'
            cartHTML += '<option value="add_file">Add a file</option>'
            cartHTML += '<option value="info_box">Info box</option>'
            cartHTML += '</select>'
            cartHTML += ' </div>'

            cartHTML += '<div>'
            cartHTML += '<button type="button" class="btn btn-default" style="margin-right:5px;" data-dismiss="modal">*</button>'
            cartHTML += '<button type="button" class="btn btn-default" data-dismiss="modal">delete</button>'
            cartHTML += '</div>'

            header.innerHTML = cartHTML

            var fieldBody = document.createElement('div');
            fieldBody.classList.add('fieldBodyContainer');
            container.appendChild(fieldBody);

            var inputBody = '<div class="col-md-12">';
            inputBody += '<label class="">Question</label>';
            inputBody += '<input name="group1[0]" value="How do you know when to solve a problem on your own or to ask for help?" name="question" type="text" required="required" class="form-control">';
            inputBody += "Get to know the candidate's work style and routine.";
            inputBody += '</div>';

            fieldBody.innerHTML = inputBody

            var answersContainer = document.createElement('div');
            answersContainer.classList.add('answersContainer', 'hidden');
            answersContainer.id = id + 'answersContainer';
            container.appendChild(answersContainer);

            var fieldList = document.getElementById('fieldList');
            fieldList.appendChild(container);
        }
    })


    function getval(sel, id) {
        // $(`#${id}`)
        var selectedContainer = document.getElementById(`${id}`);
        var answersContainer = document.getElementById(`${id}answersContainer`);

        answersContainer.classList.remove('hidden');

        var ansInnerContainer = document.createElement('div');
        ansInnerContainer.classList.add('ansInnerContainer');
        ansInnerContainer.id = id + 'ansInnerContainer';
        
        var InnerContainerHTML = '<div class="ansInnerFieldContainer" id="' + id + 'ansInnerFieldContainer">';
        InnerContainerHTML += '<label class="">Answers</label>';
        InnerContainerHTML += '<input name="group1[1]" value="Communication in the required" class="form-control" >';
        InnerContainerHTML += '</div>';
        InnerContainerHTML += '<button class="add_field" id="' + id + 'ansInnerFieldButton" style="margin-top:10px;">Add</button>';
        
        ansInnerContainer.innerHTML = InnerContainerHTML;
        
        answersContainer.appendChild(ansInnerContainer);
        
    }

    $(function() {
        $("form[id^='fieldList']").on("submit", function(e) {
            e.preventDefault();
            
            var targetDiv = document.getElementById(e.target.id).getElementsByClassName("fieldContainer")[0];
            var targetInnerDiv = document.getElementById(targetDiv.id).getElementsByClassName("answersContainer")[0];
            var targetInnerContentsDiv = document.getElementById(targetInnerDiv.id).getElementsByClassName("ansInnerContainer")[0];
            var targetContentsDiv = document.getElementById(targetInnerContentsDiv.id).getElementsByClassName("ansInnerFieldContainer")[0];
            var divId = targetContentsDiv.id;
            
            var container = document.getElementById(divId)
            var inputs = container.getElementsByTagName("input")

            console.log(inputs.length)

            var InnerContainerHTML = document.createElement('input');
            InnerContainerHTML.classList.add('form-control','innerFieldStyle');
            InnerContainerHTML.value ="Communication in the required"
            InnerContainerHTML.name =`group1[${inputs.length + 1}]`

            container.appendChild(InnerContainerHTML);

        });
    });

    function addField(event) {}
</script>