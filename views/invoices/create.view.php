<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/nav.php'); ?>
<?php require base_path('views/partials/banner.php'); ?>

<main class="dark:text-white">
    <div id="create-invoice-page" class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">

        <form method="POST" action="/invoices" id="invoice-form">
            <div class="space-y-12">

                <div class="border-b border-gray-900/10 pb-6 text-gray-900 dark:text-white">

                    <!-- client + invoice data -->
                    <div class="mt-8 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <label for="company_name" class="block uppercase text-sm font-medium leading-6">ragione sociale</label>
                            <div class="mt-2">
                                <input type="text" name="company_name" id="company_name" value="<?= $_POST['company_name'] ?? '' ?>" required class="block w-full rounded-md border-0 bg-transparent bg-transparent py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <?php if (isset($errors['company_name'])) : ?>
                                <p class="text-red-500 text-xs mt-2"><?= $errors['company_name'] ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="vat_number" class="block uppercase text-sm font-medium leading-6">partiva iva</label>
                            <div class="mt-2">
                                <input type="text" name="vat_number" id="vat_number" value="<?= $_POST['vat_number'] ?? '' ?>" required class="block w-full rounded-md border-0 bg-transparent py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <?php if (isset($errors['vat_number'])) : ?>
                                <p class="text-red-500 text-xs mt-2"><?= $errors['vat_number'] ?></p>
                            <?php endif; ?>
                        </div>


                        <div class="col-span-full">
                            <label for="address" class="block uppercase text-sm font-medium leading-6">Indirizzo</label>
                            <div class="mt-2">
                                <input type="text" name="address" id="address" value="<?= $_POST['address'] ?? '' ?>" required class="block w-full rounded-md border-0 bg-transparent py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <?php if (isset($errors['address'])) : ?>
                                <p class="text-red-500 text-xs mt-2"><?= $errors['address'] ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="invoice_number" class="block uppercase text-sm font-medium leading-6">numero fattura</label>
                            <div class="mt-2">
                                <input type="text" name="invoice_number" id="invoice_number" value="<?= $_POST['invoice_number'] ?? '' ?>" required class="block w-full rounded-md border-0 bg-transparent py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <?php if (isset($errors['invoice_number'])) : ?>
                                <p class="text-red-500 text-xs mt-2"><?= $errors['invoice_number'] ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="date" class="block uppercase text-sm font-medium leading-6">data</label>
                            <div class="mt-2">
                                <input type="date" name="date" id="date" value="<?= $_POST['date'] ?? '' ?>" required class="block w-full rounded-md border-0 bg-transparent py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>

                    </div>

                    <!-- invoice details -->
                    <div class="w-full max-w-11/12 py-10">
                        <div class="max-w-full align-middle">
                            <div class="bg-white border border-gray-200 rounded-md shadow-sm overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">

                                <div class="flex align-middle justify-between dark:bg-gray-800">
                                    <h3 class="m-4 text-sm font-medium uppercase">Prodotti o servizi offerti</h3>
                                </div>

                                <table id="invoice-details-table" class="w-full divide-y divide-gray-200 dark:divide-neutral-700 dark:bg-gray-800">
                                    <thead class="bg-gray-50 dark:bg-gray-900">
                                        <tr>

                                            <th scope="col" class="ps-6 py-3 text-start">
                                                <div class="flex items-center gap-x-2">
                                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                        Descrizione
                                                    </span>
                                                </div>
                                            </th>

                                            <th scope="col" class="max-w-20 px-2 py-3 text-start">
                                                <div class="flex justify-center items-center gap-x-2">
                                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                        Prezzo
                                                    </span>
                                                </div>
                                            </th>

                                            <th scope="col" class="max-w-20 px-1 py-3 text-start">
                                                <div class="flex justify-center items-center gap-x-2">
                                                    <span class="text-xs text-center font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                        Quantità
                                                    </span>
                                                </div>
                                            </th>

                                            <th scope="col" class="px-6 py-3 text-start">
                                                <div class="flex justify-center items-center gap-x-2">
                                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                        Subtotale
                                                    </span>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="flex justify-center items-center gap-x-2">
                                                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                        Azioni
                                                    </span>
                                                </div>
                                            </th>

                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700 text-gray-800 dark:text-white">
                                        <tr id="invoice-row" class="border-b-2">
                                            <td>
                                                <input type="text" id="description" name="invoice_details[0][description]" class="px-2 ps-6 border-0 rounded w-11/12 bg-transparent" />
                                            </td>
                                            <td>
                                                <input type="number" id="price" name="invoice_details[0][price]" class="ps-10 border-0 rounded w-11/12 text-center bg-transparent" />
                                            </td>
                                            <td>
                                                <input type="number" id="quantity" min="1" name="invoice_details[0][quantity]" class="ps-10 border-0 rounded w-11/12 text-center bg-transparent" />
                                            </td>
                                            <td class="bg-gray-200 dark:bg-gray-700">
                                                <input type="text" id="subtotal" disabled name="invoice_details[0][subtotal]" class="px-0 border-0 rounded w-11/12 bg-transparent text-center" />
                                            </td>
                                            <td class="mt-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <button type="button" id="add-row" class="text-center font-bold w-full">+</button>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>


                            </div>
                        </div>
                    </div>
                    <!-- invoice summary -->
                    <div class="flex sm:justify-end">
                        <div class="w-full max-w-2xl sm:text-end space-y-2">
                            <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-0">
                                <div class="grid sm:grid-cols-5 gap-x-3">
                                    <p class="col-span-4 text-gray-800 dark:text-neutral-200">Imponibile:</p>
                                    <p id="taxable_amount_el" class="col-span-1 text-gray-700 dark:text-neutral-500"></p>
                                </div>

                                <div class="grid sm:grid-cols-5 gap-x-3">
                                    <p class="col-span-4 text-gray-800 dark:text-neutral-200">Iva(22%):</p>
                                    <p id="vat_rate" class="col-span-1 text-gray-700 dark:text-neutral-500"></p>
                                </div>

                                <div class="grid sm:grid-cols-5 gap-x-3">
                                    <p class="col-span-4 font-bold text-gray-800 dark:text-neutral-200">Totale:</p>
                                    <p id="invoice_total_el" class="col-span-1 font-bold text-gray-700 dark:text-neutral-500"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- hidden input fields -->
                    <input type="hidden" name="invoice_total" id="invoice_total" />
                    <input type="hidden" name="taxable_amount" id="taxable_amount" />
                </div>


            </div>

            <div class="mt-6 grid">
                <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 uppercase text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">Genera fattura</button>
            </div>
        </form>

    </div>
</main>

</div>

<script src="../create.js"></script>

<?php require base_path('views/partials/footer.php'); ?>