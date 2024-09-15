function convertDateFormat(dateString) {
    // Split the date string into its components
    const [year, month, day] = dateString.split('-');

    // Rearrange and join the components into the new format
    const formattedDate = `${day}-${month}-${year}`;

    return formattedDate;
}

function validateCharInput(input) {
    //These are the only inputs for the Checkin kilometer
    const allowedChars = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    // Filter out characters that are not in the allowedChars array
    input.value = input.value.split('').filter(char => allowedChars.includes(char)).join('');
}