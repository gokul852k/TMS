function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#imageUpload").change(function () {
    readURL(this);
});

function licenceStatus(licenceExpiry) {
    let currentDate = new Date();
    let futureDate = new Date(currentDate);
    futureDate.setMonth(currentDate.getMonth() + 3);
    
    // Ensure licenceExpiry is a Date object
    licenceExpiry = new Date(licenceExpiry);
    
    if (licenceExpiry < currentDate) {
        return 'expired';
    } else if (licenceExpiry <= futureDate) {
        return 'expires';
    } else {
        return 'active';
    }
}