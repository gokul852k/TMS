getTranslations();

let tlabels1;

function getTranslations () {
    var formData2 = {
        action: 'getTranslations',
        pageId: 3
    }
    $.ajax({
        type: 'POST',
        url: '../Controllers/DailyReportController.php',
        data: formData2,
        dataType: 'json',
        success: function (response) {
            if (response.status == "success") {
                tlabels1 = response.data;
                console.log(tlabels1);
            }else {
                tlabels1 = [
                    {"translation": "Spare Parts"},                                 // 5
                    {"translation": "Quantity"},                                    // 6
                    {"translation": "Price"},                                       // 7
                    {"translation": "Select Spare"},                                // 8
                    {"translation": "Upload Bill"},                                 // 11
                ]
            }
            
        }
    });
}

let sparePart;

let sparePartCounter = 0;

$(document).ready(function () {

    //Add Shift
    $("#add-spare-part").click(async function () {
        //Driver
        //Spare parts
        if (!sparePart) {
            await sparePartAjax();
        }
        // let select2 = $('#spare-part');
        // select2.empty();  // Clear existing options

        // Add default "Select Spare" option
        sparePartSelect = '<option value="" selected>' + tlabels1[5]['translation'] + '</option>';
        if (sparePart != undefined) {
            sparePart.forEach((spar_part) => {
                sparePartSelect += '<option value="' + spar_part.spare_part_id + '">' + spar_part.spare_part_name + '</option>';
            });
        }else{
            sparePartSelect += '<option value="">No Spare Parts</option>';
        }


        sparePartCounter++;
        // tripCounters[sparePartCounter] = 1

        $('#cms-spares').append(
            `
        <div class="bms-shift" id="bms-shift-${sparePartCounter}">
            <div class="bms-shift-header">
                <p class="bms-shift-title">Spare Parts</p>
                <button class="remove-button-driver" title="Remove Spare Part" onclick="remove('bms-shift-${sparePartCounter}')"><i class="fa-solid fa-trash"></i></button>
            </div>
            <div class="bms-shift-body">
                <div class="bms-shift-details">
                    <div class="row">
                        <div class="col-sm-4">
                            
                            <label for="" class="input-label">${tlabels1[5]['translation']}</label>
                            <select class="input-field" name="spare[${sparePartCounter}][sparePartId]" required>
                                ${sparePartSelect}
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="" class="input-label">${tlabels1[6]['translation']}</label>
                            <input type="text" class="input-field" name="spare[${sparePartCounter}][spareQuantity]" placeholder="" required />
                        </div>
                        <div class="col-sm-4">
                            <label for="" class="input-label">${tlabels1[7]['translation']}</label>
                            <input type="text" class="input-field" name="spare[${sparePartCounter}][sparePrice]" placeholder="" required />
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        `
        )
    });

});

function remove(id) {
    $('#' + id).remove();
}

function updateFileName() {
    const input = document.getElementById('upload_bill');
    const label = document.getElementById('file-name');

    if (input.files.length > 0) {
        label.innerHTML = `<b>${input.files[0].name}</b>`;
    } else {
        label.innerHTML = '<b>' + tlabels1[11]['translation'] + '</b>';
    }
}