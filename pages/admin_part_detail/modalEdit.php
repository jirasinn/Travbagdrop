<?php
if (isset($_GET['id']) && $_GET['id'] == 'myStatus_1') {
    echo '
    <div id="myStatus_1" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <center>
                        <p style="font-size: 28px;">สถานะพาร์ทเนอร์</p>

                        <div class="d-flex justify-content-evenly align-items-center" style="margin-bottom: 3%;">
                            <div class="status-option" id="open" data-status="open">เปิดให้บริการ</div>
                            <div class="status-option" id="closed" data-status="closed">ปิดให้บริการ</div>
                        </div>
                        
                        <p><div class="status-option" id="cancel" data-status="cancel">ยกเลิกการเป็นพาร์ทเนอร์</div></p>
                        <textarea type="text" id="cause" name="cause" placeholder="เนื่องจาก"></textarea>

                        <div class="d-flex justify-content-evenly align-items-center" style="margin-bottom: 3%;">
                            <button type="button" id="ok">ยืนยัน</button>
                            <button type="button" id="cancelBtn" >ยกเลิก</button>
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
    ';
}
?>


<!--  -->
<style>
    /* ในส่วนของพาร์ทเนอร์ */

    textarea[type="text"] {
        display: none;
        margin: 0 auto;
        width: 80%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 14px;
        box-sizing: border-box;
        background-color: #F7F41F;
        font-size: 1em;
        resize: vertical;
    }

    .modal {
        display: none;
        /* ปิดการแสดงผลเริ่มต้น */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        margin-top: 30%;
        border-radius: 4px;
        position: relative;
        background: #fff;
        padding: 1em 2em;
        border: 1px solid #ddd;
        border-radius: 14px;
        width: 100%;
    }

    .status-option {
        cursor: pointer;
        padding: 2%;
        width: 30%;
        text-align: center;
        border-radius: 5px;
        box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
        display: inline-block;
        margin: 1%;
    }

    .status-option:hover {
        background-color: lightgray;
    }

    .status-option.active {
        background-color: #121139 !important;
        color: #fff !important;
        /* border: 2px solid #000000; */
    }

    #open{
        padding: 3%;
        width: 40%;
        background-color: #51DA10;
        border-radius: 10px;
    }
 
    #closed{
        padding: 3%;
        width: 40%;
        background-color: #FF0000;
        border-radius: 10px;
    }

    #cancel{
        padding: 3%;
        width: 50%;
        background-color: #D9D9D9;
        border-radius: 10px;
    }

    #ok{
        padding: 3%;
        width: 40%;
        background-color: #51DA10;
        border-radius: 10px;
        border: none;
    }

    #cancelBtn{
        padding: 3%;
        width: 40%;
        background-color: #F90000;
        border-radius: 10px;
        border: none;
    }

</style>