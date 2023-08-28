<?php
// Inialize session

session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
    header('Location: login page/admin.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Crystal Pay</title>
        <meta charset="utf-8" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <!-- css -->
            <link href="src/css/bootstrap.min.css" rel="stylesheet" media="screen">
                <link href="src/css/style.css" rel="stylesheet" media="screen">
                    <link href="src/css/color/default.css" rel="stylesheet" media="screen">
                        <script src="src/css/js/modernizr.custom.js"></script>
                        <script type="text/javascript" src="src/js/jquery.js"></script>
                        <link rel="stylesheet" href="default/default.css" type="text/css" media="screen" />
                        <link href="src/css/main.css" rel="stylesheet"   type="text/css"/>
                        <link href="src/css/bootstrap.css" rel="stylesheet">
                            <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
                                <link rel="stylesheet" href="/resources/demos/style.css">
                                    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
                                    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
                                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                                        <script>
                                            $(function () {
                                                $("#datepicker").datepicker();
                                                $("#payee_picker").datepicker();
                                                $("#wholepicker").datepicker();
                                            });
                                        </script>
                                        <style>
                                            #wrapper {
                                                max-width: 600px;
                                                margin: 150px auto;
                                                text-align: center;
                                            }

                                            #main-nav ul {
                                                list-style: none;
                                                margin: 0;
                                                padding: 0;
                                            }

                                            #main-nav ul li {
                                                display: inline-block;
                                                margin: 0 1em 0 1em;
                                                padding: 0.35em 0.75em 0.35em 0.75em;
                                                border-radius: 0.5em;
                                            }

                                            #main-nav ul li.active { background: #999; }

                                            #main-nav ul li.active a {
                                                color: #fff;
                                                text-decoration: none;
                                            }

                                            /* A single menu */

                                            .dropotron {
                                                background: #444;
                                                border-radius: 0.5em;
                                                list-style: none;
                                                margin: 0;
                                                min-width: 10em;
                                                padding: 0.75em 1em 0.75em 1em;
                                            }

                                            .dropotron > li {
                                                border-top: solid 1px #555;
                                                margin: 0;
                                                padding: 0;
                                            }

                                            .dropotron > li:first-child { border-top: 0; }

                                            .dropotron > li > a {
                                                color: #ccc;
                                                display: block;
                                                padding: 0.5em 0 0.5em 0;
                                                text-decoration: none;
                                            }

                                            .dropotron > li.active > a,
                                            .dropotron > li:hover > a { color: #fff; }

                                            /* Only applies to top level ("level-0") menus */

                                            .dropotron.level-0 { margin-top: 1.25em; }

                                            .dropotron.level-0:before {
                                                content: '';
                                                position: absolute;
                                                border-bottom: solid 0.5em #444;
                                                border-left: solid 0.5em transparent;
                                                border-right: solid 0.5em transparent;
                                                top: -0.5em;
                                            }
                                        </style>
                                        <script>
                                            $(function () {

                                                // Note: make sure you call dropotron on the top level <ul>
                                                $('#main-nav > ul').dropotron({
                                                    offsetY: -10 // Nudge up submenus by 10px to account for padding
                                                });

                                            });
                                        </script>
                                        </head>

                                        <body>

                                            <?php include 'site_menu/navigation-menu.php'; ?>

                                            </select>
                                            <div  style="border:0px solid #CCC; background-color: #FFFFFF;">
                                                <form action="napsa_report.php" method="post" id="sendemail">
                                                    <ul>
                                                        <br>
                                                            <li><center><h4 style="color:black"><b>Reports</b></h4></center></li>
                                                            <table  cellspacing="10" align="center"> 
                                                                <tr> 
                                                                    <td width="174">Napsa Report</td>                                                              
                                                                    <td width="238"><center><input id="datepicker" placeholder="Click here" class="form-control" type="text" name="napsa_date_report"  ></center></td>
                                                                    <td width="238"><button name="save" id="save" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-print"></span>Generate</button></center></td>
                                                                </tr>

                                                            </table>                                                  

                                                    </ul>

                                                </form>
                                                <ul>                                                   
                                                    <form action="paye_report.php" method="post">
                                                        <table  cellspacing="10" align="center"> 
                                                            <tr> 
                                                                <td width="174">PAYE Report</td>                                                              
                                                                <td width="238"><center><input id="payee_picker" placeholder="Cick here" class="form-control" type="text" name="payee_date_report" ></center></td>
                                                                <td width="238"><button name="save" id="save" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-print"></span>Generate</button></center></td>
                                                            </tr>

                                                        </table> 
                                                </ul>

                                                </form>
                                                <ul>

                                                    <form action="report.php" method="post" id="sendemail">
                                                        <table  cellspacing="10" align="center"> 
                                                            <tr> 
                                                                <td width="174">Pay roll Report</td>                                                              
                                                                <td width="238"><center><input id="wholepicker" placeholder="Click here" class="form-control" type="text" name="whole_date_report" ></center></td>
                                                                <td width="238"><button name="save" id="save" type="submit" class="btn btn-default"><span class="glyphicon glyphicon-print"></span>Generate</button></center></td>
                                                            </tr>

                                                        </table> 

                                                </ul>

                                                </form>

                                            </div>

                                            </div>
                                        </body>
                                        <br></br><br></br>
                                        <?php include 'site_menu/footer.php'; ?> 
                                        </html>
