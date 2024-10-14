<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/nav.php'); ?>
<?php require base_path('views/partials/banner.php'); ?>

<main class="dark:text-white">

    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">


        <div class="bg-white dark:bg-gray-700">
            <h2 class="ms-2 pb-3 text-end text-xl font-semibold hover:underline">
                <a href="/invoices/create">Aggiungi nuova fattura</a>
            </h2>


            <div class="flex flex-col">
                <h2 class="ms-2 pb-3 text-xl font-semibold">Le tue fatture</h2>

                <!-- SearchBox -->
                <div class="relative mb-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-3.5">
                            <svg class="shrink-0 size-4 text-gray-400 dark:text-white/60" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>
                        <input id="search-input" class="py-3 ps-10 pe-4 block w-full border-gray-200 rounded-lg text-sm bg-transparent focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" type="text" role="combobox" aria-expanded="false" placeholder="Cerca cliente..." value="">
                    </div>

                    <div class="absolute z-50 w-full bg-white border border-gray-200 rounded-lg dark:bg-neutral-800 dark:border-neutral-700" style="display: none;" data-hs-combo-box-output="">
                        <div class="max-h-72 rounded-b-lg overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500" data-hs-combo-box-output-items-wrapper=""></div>
                    </div>
                </div>
                <!-- end SearchBox -->

                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="border rounded-lg overflow-hidden dark:border-neutral-700">

                            <?php if (!empty($invoices)) : ?>

                                <table id="invoices-table" class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">data</th>
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">N.</th>
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">ragione sociale</th>
                                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">totale</th>
                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">azioni</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                        <?php foreach ($invoices as $invoice) : ?>
                                            <tr class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"><?= htmlspecialchars(date('d-m-Y', strtotime($invoice['date']))) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200"><?= htmlspecialchars($invoice['number']) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"><?= htmlspecialchars($invoice['company_name']) ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"><?= number_format(htmlspecialchars($invoice['total']), 2, ',', '.') . '€' ?></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                                    <ul class="flex flex-col justify-center items-center">
                                                        <li>
                                                            <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
                                                                <a href="/invoice?id=<?= $invoice['id'] ?>">Mostra</a>
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-none focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
                                                                <a href="/invoice/edit?id=<?= $invoice['id'] ?>">Modifica</a>
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>

                            <?php else: ?>
                                <p class="p-2">Nessuna fattura trovata.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
</div>

<!-- search clients input logic -->
<script>
    // function to filter table rows based on the search input
    function filterTable() {
        const searchInput = document.getElementById('search-input').value.toLowerCase();

        // get all rows from the table's tbody
        const tableRows = document.querySelectorAll('#invoices-table tbody tr');

        tableRows.forEach(row => {
            // get clients td 
            const clientName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

            // check search input content
            // and show only the results
            if (clientName.includes(searchInput)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // search every time the user types
    document.getElementById('search-input').addEventListener('input', filterTable);
</script>

<?php require base_path('views/partials/footer.php'); ?>