function downloadPdf(base64Data, name) {
    const link = document.createElement('a');
    link.href = 'data:application/pdf;base64,' + base64Data;
    link.download = `${name}.pdf`;
    link.click();
}