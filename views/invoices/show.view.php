<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/nav.php'); ?>
<?php require base_path('views/partials/banner.php'); ?>

<main class="dark:text-white">
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">

        <!-- invoice -->
        <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto my-4 sm:my-10">
            <div class="sm:w-11/12 lg:w-3/4 mx-auto">

                <div class="flex flex-col p-6 bg-white shadow-md rounded-xl dark:bg-gray-800">
                    <button type="button" class="mb-4 gap-x-2 text-sm text-end font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
                        <a href="/invoice/edit?id=<?= $invoice['id'] ?>">Modifica</a>
                    </button>
                    <!-- invoice info  -->
                    <div class="flex justify-between">
                        <!-- client data -->
                        <div>
                            <h3 class="text-sm text-gray-800 dark:text-neutral-200">Fattura a:</h3>
                            <h3 class="font-semibold text-gray-800 dark:text-neutral-200"><?= htmlspecialchars($invoice['company_name']) ?></h3>
                            <p class="uppercase text-gray-500 dark:text-neutral-500">
                                <?= htmlspecialchars($invoice['address']) ?>
                            </p>
                            <p class="uppercase text-gray-500 dark:text-neutral-500">
                                <?= htmlspecialchars($invoice['vat_number']) ?>
                            </p>
                        </div>

                        <!-- invoice date -->
                        <div class="sm:text-end space-y-2">
                            <div class="flex gap-1">
                                <p class="text-gray-800 dark:text-neutral-200">Data fattura:</p>
                                <p class="text-gray-800 dark:text-neutral-500"><?= htmlspecialchars(date('d-m-Y', strtotime($invoice['date']))) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- invoice number -->
                    <div class="flex justify-center items-baseline gap-3">
                        <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 dark:text-neutral-200">Fattura n.</h2>
                        <span class="font-semibold text-lg text-gray-800 dark:text-neutral-500"><?= htmlspecialchars($invoice['number']) ?></span>
                    </div>
                    <!-- end invoice number -->

                    <!-- Table -->
                    <div class="mt-6 border rounded overflow-hidden dark:border-neutral-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <thead class="dark:bg-neutral-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-start text-xs font-semibold text-gray-800 uppercase dark:text-neutral-500">descrizione</th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-800 uppercase dark:text-neutral-500">quantità</th>
                                    <th scope="col" class="px-6 py-3 text-end text-xs font-semibold text-gray-800 uppercase dark:text-neutral-500">prezzo</th>
                                    <th scope="col" class="px-6 py-3 text-end text-xs font-semibold text-gray-800 uppercase dark:text-neutral-500">subtotale</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">

                                <?php foreach ($details as $row): ?>
                                    <tr class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                                        <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"><?= htmlspecialchars($row['description']) ?></td>
                                        <td class="px-6 py-3 whitespace-nowrap text-center text-sm text-gray-800 dark:text-neutral-200"><?= htmlspecialchars($row['quantity']) ?></td>
                                        <td class="px-6 py-3 whitespace-nowrap text-end text-sm text-gray-800 dark:text-neutral-200"><?= number_format(htmlspecialchars($row['price']), 2, ',', '.') . '€' ?></td>
                                        <td class="px-6 py-3 whitespace-nowrap text-end text-sm text-gray-800 dark:text-neutral-200"><?= number_format(htmlspecialchars($row['subtotal']), 2, ',', '.') . '€' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- end table -->

                    <!-- price summary -->
                    <div class="mt-8 flex sm:justify-end">
                        <div class="w-full max-w-2xl sm:text-end space-y-2">
                            <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-0">
                                <div class="grid sm:grid-cols-5 gap-x-3">
                                    <p class="col-span-4 text-gray-800 dark:text-neutral-200">Imponibile:</p>
                                    <p class="col-span-1 text-gray-700 dark:text-neutral-500"><?= number_format($invoice['taxable_amount'], 2, ',', '.') . '€' ?></p>
                                </div>

                                <div class="grid sm:grid-cols-5 gap-x-3">
                                    <p class="col-span-4 text-gray-800 dark:text-neutral-200">Iva(22%):</p>
                                    <p class="col-span-1 text-gray-700 dark:text-neutral-500"><?= number_format(($invoice['taxable_amount'] * 0.22), 2, ',', '.') . '€' ?></p>
                                </div>

                                <div class="grid sm:grid-cols-5 gap-x-3">
                                    <p class="col-span-4 font-bold text-gray-800 dark:text-neutral-200">Totale:</p>
                                    <p class="col-span-1 font-bold text-gray-700 dark:text-neutral-500"><?= number_format($invoice['total'], 2, ',', '.') . '€' ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end price summary -->



                    <!-- hidden form -->
                    <form method="POST" action="/generate-pdf.php">
                        <input type="hidden" name="company_name" id="company_name" value="<?= $invoice['company_name'] ?>">
                        <input type="hidden" name="vat_number" id="vat_number" value="<?= $invoice['vat_number'] ?>">
                        <input type="hidden" name="address" id="address" value="<?= $invoice['address'] ?>">
                        <input type="hidden" name="invoice_number" id="invoice_number" value="<?= $invoice['number'] ?>">
                        <input type="hidden" name="date" id="date" value="<?= $invoice['date'] ?>">
                        <input type="hidden" name="invoice_details[0][description]" id="description-0" />
                        <input type="hidden" name="invoice_details[0][price]" id="price-0" />
                        <input type="hidden" name="invoice_details[0][quantity]" id="quantity-0" />
                        <input type="hidden" name="invoice_details[0][subtotal]" id="subtotal-0" />

                        <?php foreach ($details as $index => $row): ?>
                            <input type="hidden" name="invoice_details[<?= $index ?>][description]" id="description-<?= $index + 1 ?>" value="<?= htmlspecialchars($row['description']) ?>" />
                            <input type="hidden" name="invoice_details[<?= $index ?>][price]" id="price-<?= $index + 1 ?>" value="<?= htmlspecialchars($row['price']) ?>" />
                            <input type="hidden" name="invoice_details[<?= $index ?>][quantity]" id="quantity-<?= $index + 1 ?>" value="<?= htmlspecialchars($row['quantity']) ?>" />
                            <input type="hidden" name="invoice_details[<?= $index ?>][subtotal]" id="subtotal-<?= $index + 1 ?>" value="<?= htmlspecialchars($row['subtotal']) ?>" />
                        <?php endforeach; ?>

                        <input type="hidden" name="invoice_total" id="invoice_total" value="<?= $invoice['total'] ?>" />
                        <input type="hidden" name="vat_rate" id="vat_rate" value="<?= ($invoice['taxable_amount'] * 0.22) ?>" />
                        <input type="hidden" name="taxable_amount" id="taxable_amount" value="<?= $invoice['taxable_amount'] ?>" />

                        <!-- Buttons -->
                        <button type="submit" class="mt-6 flex justify-start gap-x-3">
                            <span class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                    <polyline points="7 10 12 15 17 10" />
                                    <line x1="12" x2="12" y1="15" y2="3" />
                                </svg>
                                Invoice PDF
                            </span>

                        </button>
                    </form>

                </div>
            </div>



        </div>


    </div>


    </div>
</main>

<?php require base_path('views/partials/footer.php'); ?>