function convertDateFormat(dateString) {
    // Split the date string into its components
    const [year, month, day] = dateString.split('-');

    // Rearrange and join the components into the new format
    const formattedDate = `${day}-${month}-${year}`;

    return formattedDate;
}