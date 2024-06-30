<?php
require_once './header.php';
require_once './navbar.php';
?>

<link rel="stylesheet" href="../../../Common/Common file/card.css">
<link rel="stylesheet" href="../../../Common/Common file/header.css">
<link rel="stylesheet" href="../../../Common/Common file/pop_up.css">
<link rel="stylesheet" href="./Style/driver.css">
<style>
    h2 {
        text-align: center;
        padding: 20px 0;
    }
</style>

<div class="register-driver">
    <div class="container box-container box-head w3-animate-top">
        <div class="row row-head">
            <div class="">
                <h4 class="heading">Driver Details</h4>
            </div>
            <div class="row-head-div-2">
                <button class="button-1 head-button3" onclick="popupOpen('driver-add')"><i
                        class="fa-solid fa-user-plus"></i>Add Driver</button>
                <button class="button-1 head-button2">Download<i class="fa-solid fa-download"></i></button>
            </div>
        </div>
    </div>
    <div class="container box-container w3-animate-top">
        <div class="row row-head">
            <div class="content">
                <div class="container-fluid">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 card-row-d-r">
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Total Drivers</p>
                                                <h4 class="my-1 text-info">20</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
                                                <i class="fa-solid fa-user-pilot"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Active Drivers</p>
                                                <h4 class="my-1 text-info t-c-2">15</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                                <i class="fa-solid fa-user-check"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Expired Licenses</p>
                                                <h4 class="my-1 text-info t-c-5">0</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
                                                <i class="fa-solid fa-file-xmark"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col card-col-d-r">
                            <div class="card radius-10 border-start border-0 border-3 border-info">
                                <a href="#" class="no-underline">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <p class="mb-0 text-secondary">Upcoming Expirations</p>
                                                <h4 class="my-1 text-info t-c-3">3</h4>
                                            </div>
                                            <div
                                                class="widgets-icons-2 rounded-circle  bg-gradient-blooker text-white ms-auto">
                                                <i class="fa-solid fa-memo-circle-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container box-container w3-animate-bottom">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <table
                            summary="This table shows how to create responsive tables using Datatables' extended functionality"
                            class="table table-bordered table-hover dt-responsive">

                            <thead>
                                <tr>
                                    <th class="th">Vehicle No</th>
                                    <th class="th">Name</th>
                                    <th class="th">Mobile</th>
                                    <th class="th">Company</th>
                                    <th class="th">License No</th>
                                    <th class="th">Insurance No</th>
                                    <th class="th">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view" onclick="popupOpen('driver-view')"><i
                                                class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        TN8347t7
                                    </td>
                                    <td>
                                        gokulraj
                                    </td>
                                    <td>
                                        9157645287
                                    </td>
                                    <td>
                                        ZOHO
                                    </td>
                                    <td>
                                        Lo9i393i9
                                    </td>
                                    <td>
                                        I8782r8v
                                    </td>
                                    <td class="th-btn">
                                        <button class="table-btn view"><i class="fa-duotone fa-eye"></i></button>
                                        <button class="table-btn edit"><i
                                                class="fa-duotone fa-pen-to-square"></i></button>
                                        <button class="table-btn delete"><i class="fa-duotone fa-trash"></i></button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Add Driver Pop ups-->
<div class="tms-pop-up" id="driver-add">
    <div class="pop-up-bg" onclick="popupClose('driver-add')"></div>
    <div class="pop-up-card scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-user-pilot"></i>Add new driver</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('driver-add')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="register-driver">
                <form enctype="multipart/form-data" id="driver-form">
                    <div class="container box-container">
                        <div class="row">
                            <h4 class="heading">Driver Details</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' id="imageUpload" name="imageUpload"
                                            accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview" title="Click plus to upload"
                                            style="background-image: url(../../Assets/Developer/image/manager.png);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="text" class="input-field" name="fullname"
                                            placeholder="Full Name" />
                                        <input type="number" class="input-field" name="mobile"
                                            placeholder="Mobile Number" />
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="email" class="input-field" name="email" placeholder="Mail ID" />
                                        <input type="text" class="input-field" name="password" placeholder="Password" />
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="text" class="input-field" name="address" placeholder="Address" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <input type="text" class="input-field" name="state" placeholder="State" />
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="input-field" name="district" placeholder="District" />
                            </div>
                            <div class="col-sm-4">
                                <input type="number" class="input-field" name="pincode" placeholder="Pin Code" />
                            </div>
                        </div>

                    </div>
                    <div class="container box-container">
                        <div class="row">
                            <h4 class="heading">Documents</h4>
                        </div>
                        <div class="row">
                            <div class="col-sm-4 double-input">
                                <label for="exampleFormControlFile1" class="drop-container" id="dropcontainer">
                                    <span class="drop-title">Upload Driving Licence</span>
                                    <br>
                                    <input type="file" class="form-control-file" id="driving-licence"
                                        name="driving-licence" accept="image/*,.pdf" />
                                </label>
                                <input type="text" class="input-field" name="driving-licence-no"
                                    placeholder="Driving Licence Number" />
                                <label for="" class="input-label">Licence Expiry Date</label>
                                <input type="date" class="input-field" name="licence-expiry" />

                            </div>
                            <div class="col-sm-4 double-input">
                                <label for="exampleFormControlFile1" class="drop-container" id="dropcontainer">
                                    <span class="drop-title">Upload Aadhar Card</span>
                                    <br>
                                    <input type="file" class="form-control-file" id="aadhar-card" name="aadhar-card"
                                        accept="image/*,.pdf" />
                                </label>
                                <input type="number" class="input-field" name="aadhar-no" placeholder="Aadhar Number" />
                            </div>
                            <div class="col-sm-4 double-input">
                                <label for="exampleFormControlFile1" class="drop-container" id="dropcontainer">
                                    <span class="drop-title">Upload PAN Card</span>
                                    <br>
                                    <input type="file" class="form-control-file" id="pan-card" name="pan-card"
                                        accept="image/*,.pdf" />
                                </label>
                                <input type="text" class="input-field" name="pan-no" placeholder="PAN Number" />
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <button type="submit" name="submit" class="button-1">Register Driver</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--View Driver Pop ups-->
<div class="tms-pop-up" id="driver-view">
    <div class="pop-up-bg" onclick="popupClose('driver-view')"></div>
    <div class="pop-up-card scrollbar w3-animate-top">
        <div class="pop-up-card-content">
            <div class="container box-container box-head">
                <div class="row row-head">
                    <div class="">
                        <h4 class="heading"><i class="fa-solid fa-user-pilot"></i>Driver Details</h4>
                    </div>
                    <div class="row-head-div-2">
                        <button class="button-1 head-button2" title="close" onclick="popupClose('driver-view')"><i
                                class="fa-solid fa-xmark"></i></button>
                    </div>
                </div>
            </div>
            <div class="container driver-info">
                <div class="row">
                    <div class="col-sm-3 p-r-0 m-b-10">
                        <div class="driver-info-left box-container-2 h-100">
                            <div class="row">
                                <div class="col-sm-12 info-profile-image-div">
                                    <img src="../../Assets/User/Driver image/20240629110906_EFCafuyWOTNb8q27.png"
                                        alt="profile image" class="info-profile-image">
                                </div>
                                <div class="col-sm-12">
                                    <div class="info-div">
                                        <p class="info-title">Personal information</p>
                                        <div class="infos">
                                            <p class="info-heading">Name</p>
                                            <p class="info-content">Gokulraj</p>
                                        </div>
                                        <div class="infos">
                                            <p class="info-heading">Email</p>
                                            <p class="info-content">gokul952k@gmail.com</p>
                                        </div>
                                        <div class="infos">
                                            <p class="info-heading">Mobile Number</p>
                                            <p class="info-content">9628974940</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="driver-info-right box-container-2 m-b-10">
                            <div class="row row-head">
                                <div class="content">
                                    <div class="container-fluid">
                                        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 card-row-d-r">
                                            <div class="col card-col-d-r">
                                                <div class="card radius-10 border-start border-0 border-3 border-info">
                                                    <a href="#" class="no-underline">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <p class="mb-0 text-secondary">Total Kilometers</p>
                                                                    <h4 class="my-1 text-info">20</h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
                                                                    <i class="fa-solid fa-bus"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col card-col-d-r">
                                                <div class="card radius-10 border-start border-0 border-3 border-info">
                                                    <a href="#" class="no-underline">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <p class="mb-0 text-secondary">Fuel Efficiency
                                                                    </p>
                                                                    <h4 class="my-1 text-info t-c-2">15</h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                                                    <i class="fa-solid fa-gas-pump"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col card-col-d-r">
                                                <div class="card radius-10 border-start border-0 border-3 border-info">
                                                    <a href="#" class="no-underline">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <p class="mb-0 text-secondary">Safety Score
                                                                    </p>
                                                                    <h4 class="my-1 text-info t-c-5">-</h4>
                                                                </div>
                                                                <div
                                                                    class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
                                                                    <i class="fa-solid fa-shield-check"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="driver-info-right box-container-2 m-b-10">
                            <div class="row">
                                <p class="info-title">Driver information</p>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Licence Number</p>
                                        <p class="info-content">DX3480G334</p>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Licence Expiry Date</p>
                                        <p class="info-content">08-05-2100</p>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Aadhar Number</p>
                                        <p class="info-content">8523582564528</p>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">PAN Number</p>
                                        <p class="info-content">PMF52800</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="driver-info-right box-container-2 m-b-10">
                            <div class="row">
                                <p class="info-title">Documents</p>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Licence</p>
                                        <a href="" class="document-view d-v-1">
                                            <i class="fa-duotone fa-file-invoice"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">Aadhar card</p>
                                        <a href="" class="document-view d-v-2">
                                            <i class="fa-duotone fa-file-invoice"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="infos">
                                        <p class="info-heading">PAN card</p>
                                        <a href="" class="document-view  d-v-3">
                                            <i class="fa-duotone fa-file-invoice"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="../../../Common/Common file/pop_up.js"></script>
<script src="../../../Common/Common file/data_table.js"></script>
<script src="./js/driver.js"></script>
<?php
require_once './footer.php';
?>