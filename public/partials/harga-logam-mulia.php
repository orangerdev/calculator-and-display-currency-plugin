<div class="hlm">
    <form id="hlm-datatable-filter" class="hlm-grid-inline" action="">
        <div class="hlm-col">
            <div class="hlm-field-inline">
                <label for="harga_dalam"><?php _e( 'Harga Dalam', 'calculator-and-display-currency' ); ?></label>
                <select name="harga_dalam" id="harga_dalam">
                    <option value="USD / oz">USD / oz</option>
                </select>
            </div>
        </div>
        <div class="hlm-col">
            <div class="hlm-field-inline">
                <label for="logam"><?php _e( 'Logam', 'calculator-and-display-currency' ); ?></label>
                <select name="logam" id="logam">
                    <option value=""><?php _e( 'Semua', 'calculator-and-display-currency' ); ?></option>
                    <!-- <option value="platinum">Platinum</option>
                    <option value="palladium">Palladium</option>
                    <option value="rhadium">Rhadium</option> -->
                </select>
            </div>
        </div>
        <div class="hlm-col">
            <div class="hlm-alert hlm-alert-warning">
                <p><?php echo sprintf( __( 'Update: %s', 'calculator-and-display-currency' ), $update_date ) ?></p>
            </div>
        </div>
    </form>
    <div class="hlm-grid">
        <div class="hlm-col-50">
            <table id="hlm-datatable">
                <thead>
                    <tr>
                        <th><?php _e( 'Tanggal','calculator-and-display-currency' ); ?></th>
                        <th><?php _e( 'Platinum','calculator-and-display-currency' ); ?></th>
                        <th><?php _e( 'Palladium','calculator-and-display-currency' ); ?></th>
                        <th><?php _e( 'Rhadium','calculator-and-display-currency' ); ?></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div class="hlm-alert hlm-alert-warning">
                <p><?php echo sprintf( __( 'Pembaruan terakhir: %s, Data di perbarui setiap hari kerja', 'calculator-and-display-currency' ), $update_date ) ?></p>
            </div>
        </div>
        <div class="hlm-col-50">
            <div class="hlm-chart">
                <div class="hlm-chart-header">
                    <h3><?php _e( 'Riwayat Harga Logam','calculator-and-display-currency' ); ?></h3>
                    <p class="hlm-saat-ini"><?php echo $hlm_saat_ini; ?></p>
                </div>
                <div class="hlm-chart-content">
                    <canvas id="hlm-chart-js" height="200px"></canvas>
                </div>
            </div>
        </div>
    </div>
<div>