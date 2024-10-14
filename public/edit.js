document.addEventListener('DOMContentLoaded', (event) => {

    // functions to call only in the create or edit page
    const isEditPage = document.getElementById('edit-invoice-page');
    if (isEditPage) {

        const invoiceDetailsTable = document.getElementById('invoice-details-table');
        const invoiceTotalEl = document.getElementById('invoice_total_el');
        const taxableAmountEl = document.getElementById('taxable_amount_el');
        const vatRateEl = document.getElementById('vat_rate');
        const invoiceTotalInput = document.getElementById('invoice_total');
        const taxableAmountInput = document.getElementById('taxable_amount');

        // init row index to 1
        let rowIndex = 1;

        const formatCurrency = (amount) => {
            return new Intl.NumberFormat('it-IT', {
                style: 'currency',
                currency: 'EUR'
            }).format(amount);
        };

        // calculate subtotal price
        function calculateSubtotal(row) {
            const priceInput = row.querySelector('input[name^="invoice_details"][name$="[price]"]');
            const quantityInput = row.querySelector('input[name^="invoice_details"][name$="[quantity]"]');
            const subtotalInput = row.querySelector('input[name^="invoice_details"][name$="[subtotal]"]');

            const price = parseFloat(priceInput.value) || 0;
            const quantity = parseInt(quantityInput.value) || 0;

            const subtotal = price * quantity;
            subtotalInput.value = subtotal.toFixed(2);
            return subtotal;
        };

        // calculate taxable amount, vat rate and invoice total
        function calculateTotals() {
            let total = 0;
            const rows = invoiceDetailsTable.querySelectorAll('tbody tr[data-row-index]');

            rows.forEach((row) => {
                total += calculateSubtotal(row);
            });

            const vat = total * 0.22;
            const invoiceTotal = total + vat;

            // update the DOM with the update values
            taxableAmountEl.innerText = formatCurrency(total);
            vatRateEl.innerText = formatCurrency(vat);
            invoiceTotalEl.innerText = formatCurrency(invoiceTotal);

            // update hidden inputs
            invoiceTotalInput.value = invoiceTotal.toFixed(2);
            taxableAmountInput.value = total.toFixed(2);
        };

        // update totals on input change
        invoiceDetailsTable.addEventListener('input', (event) => {
            const target = event.target;
            if (target.matches('input[name^="invoice_details"][name$="[price]"], input[name^="invoice_details"][name$="[quantity]"]')) {
                calculateTotals();
            }
        });

        calculateTotals();


        // get table el to add rows
        const invoiceTable = document.querySelector("#invoice-details-table tbody");
        const addRowButton = document.getElementById("add-row");
        let newRow;

        // add new row
        function addNewRow() {
            // get input values
            console.log(document.getElementById('description-0'));
            let description = document.getElementById('description-0').value;
            let price = parseFloat(document.getElementById('price-0').value) || 0;
            let quantity = parseInt(document.getElementById('quantity-0').value) || 0;
            const subtotal = (price * quantity).toFixed(2);


            // avoid adding empty rows
            if (!description || !price || !quantity) {
                return;
            }

            // find last index value
            const rows = document.querySelectorAll('tr[data-row-index]');
            let lastIndex = 0;
            if (rows.length > 0) {
                lastIndex = parseInt(rows[rows.length - 1].getAttribute('data-row-index'));
            }

            rowIndex = lastIndex + 1;

            // add row
            newRow = document.createElement("tr");
            newRow.setAttribute('data-row-index', rowIndex);

            newRow.innerHTML = `
                <td>
                    <input type="text" name="invoice_details[${rowIndex}][description]" value="${description}" class="px-2 ps-6 border-0 rounded w-11/12 bg-transparent" />
                </td>
                <td>
                    <input type="number" name="invoice_details[${rowIndex}][price]" value="${price}" class="ps-10 border-0 rounded w-11/12 text-center bg-transparent" />
                </td>
                <td>
                    <input type="number" name="invoice_details[${rowIndex}][quantity]" value="${quantity}" class="border-0 rounded w-11/12 text-center bg-transparent" />
                </td>
                <td class="bg-gray-200 dark:bg-gray-700">
                    <input type="text" name="invoice_details[${rowIndex}][subtotal]" value="${subtotal}" class="px-0 border-0 rounded w-11/12 bg-transparent text-center pointer-events-none" />
                </td>
                <td class="mt-2 hover:bg-gray-200 dark:hover:bg-gray-700">
                    <button type="button" class="delete-row text-center font-bold w-full">-</button>
                </td>
            `;

            // add new row to table
            invoiceTable.appendChild(newRow);
            rowIndex++;

            // clear inputs value
            document.getElementById('description-0').value = '';
            document.getElementById('price-0').value = '';
            document.getElementById('quantity-0').value = '';
            document.getElementById('subtotal-0').value = '';

            calculateTotals();
        }

        // remove row on click 
        invoiceTable.addEventListener('click', (event) => {
            if (event.target.classList.contains('delete-row')) {
                // get row index of the clicked el
                rowIndex = event.target.closest('tr').getAttribute('data-row-index');
                const row = invoiceTable.querySelector(`tr[data-row-index="${rowIndex}"]`);
                if (row) {
                    row.remove();
                    calculateTotals();
                }
            }
        })

        // update calculations
        function attachInputListeners(index) {
            const priceInput = document.getElementById(`price-${index}`);
            const quantityInput = document.getElementById(`quantity-${index}`);
            const subtotalInput = document.getElementById(`subtotal-${index}`);

            function updateSubtotal() {
                const price = parseFloat(priceInput.value) || 0;
                const quantity = parseInt(quantityInput.value) || 0;
                const subtotal = price * quantity;
                subtotalInput.value = subtotal;
                calculateTotals();
            };

            // update on input change
            priceInput.addEventListener("input", updateSubtotal);
            quantityInput.addEventListener("input", updateSubtotal);
        }

        addRowButton.addEventListener("click", addNewRow);



        // calculate subtotals and totals for each row on window loading
        document.querySelectorAll("tbody tr").forEach((row, index) => {
            attachInputListeners(index);
            calculateTotals();
        });

    }
});
