// invoice
// add new row -> #add-row
// table row -> #invoice-row
// delete row -> .delete-row


// calculate subtotal price
function calculateSubtotal() {
    const quantity = document.getElementById('quantity').value;
    const price = document.getElementById('price').value;
    const subtotal = quantity * price;
    document.getElementById('subtotal').value = `${subtotal}€`;
}

window.addEventListener('DOMContentLoaded', (event) => {

    // functions to call only in the create or edit page
    const isCreatePage = document.getElementById('create-invoice-page');
    if (isCreatePage) {

        // calculate subtotal on quantity or price change
        document.getElementById('quantity').addEventListener('input', calculateSubtotal);
        document.getElementById('price').addEventListener('input', calculateSubtotal);

        // calculate taxable amount, vat rate and invoice total
        function calculateTotals() {
            let subtotals = document.querySelectorAll('input[name^="invoice_details"][name$="[subtotal]"]');
            let taxable_amount = 0;
            let total = 0;

            // subtotals sum
            subtotals.forEach((subtotal) => {
                console.log(parseFloat(subtotal.value));

                taxable_amount += parseFloat(subtotal.value) || 0;
            });

            // calculate vat rate e total 
            let vat_rate = taxable_amount * 0.22;
            total = taxable_amount + vat_rate;

            // update the DOM with the update values
            document.getElementById('taxable_amount_el').textContent = `${taxable_amount.toLocaleString('it', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}€`;
            document.getElementById('vat_rate').textContent = `${vat_rate.toLocaleString('it', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}€`;
            document.getElementById('invoice_total_el').textContent = `${total.toLocaleString('it', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}€`;

            // add hidden inputs for total and taxable amount to send data to server
            let totalField = document.getElementById('invoice_total');
            if (!totalField) {
                totalField = document.createElement('input');
                totalField.type = 'hidden';
                totalField.name = 'invoice_total';
                totalField.id = 'invoice_total';
                document.getElementById('invoice-form').appendChild(totalField);
            }
            totalField.value = total.toFixed(2);

            let taxableField = document.getElementById('taxable_amount');
            if (!taxableField) {
                taxableField = document.createElement('input');
                taxableField.type = 'hidden';
                taxableField.name = 'taxable_amount';
                taxableField.id = 'taxable_amount';
                document.getElementById('invoice-form').appendChild(taxableField);
            }
            taxableField.value = taxable_amount.toFixed(2);
        }

        // calculate totals for each new row
        document.getElementById('add-row').addEventListener('click', calculateTotals);

        // calculate totals on input change
        document.querySelectorAll('input').forEach(function (input) {
            input.addEventListener('input', calculateTotals);
        });

        // init row index to 1
        let rowIndex = 1;

        const addRow = document.getElementById('add-row');
        addRow.addEventListener('click', function () {

            // get input values
            const description = document.getElementById('description').value;
            const quantity = document.getElementById('quantity').value;
            const price = document.getElementById('price').value;
            const subtotal = document.getElementById('subtotal').value;

            // avoid adding empty rows
            if (!description || !quantity || !price || !subtotal) {
                return;
            }

            // add a new row with hidden inputs to send data to server
            const table = document.getElementById('invoice-details-table').getElementsByTagName('tbody')[0];
            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td class="py-2 ps-6">${description}</td>
                <td class="py-2 text-center">${price}</td>
                <td class="py-2 text-center">${quantity}</td>
                <td class="py-2 text-center bg-gray-200 dark:bg-gray-700">${subtotal}</td>
                <td class="mt-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <button type="button" class="delete-row text-center font-bold w-full">-</button>
                </td>
                <input type="hidden" name="invoice_details[${rowIndex}][description]" value="${description}" />
                <input type="hidden" name="invoice_details[${rowIndex}][price]" value="${price}" />
                <input type="hidden" name="invoice_details[${rowIndex}][quantity]" value="${quantity}" />
                <input type="hidden" name="invoice_details[${rowIndex}][subtotal]" value="${subtotal}" />
            `;

            table.appendChild(newRow);

            // increment row index
            rowIndex++;

            // clear inputs value
            document.getElementById('description').value = '';
            document.getElementById('quantity').value = '';
            document.getElementById('price').value = '';
            document.getElementById('subtotal').value = '';

            // remove row on click
            newRow.querySelector('.delete-row').addEventListener('click', function () {
                newRow.remove();
                calculateTotals();
            });
        })
    }
});