<div class="hlm">
    <form id="hlm-datatable-filter" class="hlm-grid-inline" action="">
        <div class="hlm-col">
            <div class="hlm-field-inline">
                <label for="harga_dalam"><?php _e( 'Price In', 'calculator-and-display-currency' ); ?></label>
                <select name="harga_dalam" id="harga_dalam">
                    <?php
                    $currencies = hlm_get_currencies();
                    foreach ( $currencies as $key => $value) :
                    ?>
                        <option value="<?php echo $key; ?>"><?php echo $key; ?></option>
                    <?php
                    endforeach;
                    ?>
                </select>
            </div>
        </div>
        <div class="hlm-col">
            <div class="hlm-field-inline">
                <label for="logam"><?php _e( 'Metal', 'calculator-and-display-currency' ); ?></label>
                <select name="logam" id="logam">
                    <option value=""><?php _e( 'All', 'calculator-and-display-currency' ); ?></option>
                    <option value="platinum">Platinum</option>
                    <option value="palladium">Palladium</option>
                    <option value="rhadium">Rhodium</option>
                </select>
            </div>
        </div>
        <div class="hlm-col">
            <div class="hlm-alert hlm-alert-warning">
                <p><?php echo sprintf( _x( 'Update: %s', 'calculator-and-display-currency' ), '<span class="hlm-latest-price-date">_</span>' ) ?></p>
            </div>
        </div>
    </form>
    <div class="hlm-grid">
        <input type="hidden" id="hlm-table-load-status" value="">
        <input type="hidden" id="hlm-chart-load-status" value="">
        <div class="hlm-col-50">
            <table id="hlm-datatable">
                <thead>
                    <tr>
                        <th><?php _e( 'Date','calculator-and-display-currency' ); ?></th>
                        <th><?php _e( 'Platinum','calculator-and-display-currency' ); ?></th>
                        <th><?php _e( 'Palladium','calculator-and-display-currency' ); ?></th>
                        <th><?php _e( 'Rhodium','calculator-and-display-currency' ); ?></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <div class="hlm-alert hlm-alert-warning">
                <p><?php echo sprintf( _x( 'Last update: %s, Data is updated every working day', 'calculator-and-display-currency' ), '<span class="hlm-latest-price-date">_</span>' ) ?></p>
            </div>
        </div>
        <div class="hlm-col-50">
            <div class="hlm-chart">
                <div class="hlm-chart-header">
                    <h3><?php echo sprintf( _x( 'Latest Prices: %s','calculator-and-display-currency' ), '<span class="hlm-latest-price-date">_</span>' ); ?></h3>
                    <div class="hlm-grid">
                        <div class="hlm-col-33">
                            <div class="hlm-ltp-item">
                                <p><?php _e( 'Platinum','calculator-and-display-currency' ); ?></p>
                                <p class="hlm-saat-ini hlm-saat-ini-plt">_</p>
                            </div>
                        </div>
                        <div class="hlm-col-33">
                            <div class="hlm-ltp-item">
                                <p><?php _e( 'Palladium','calculator-and-display-currency' ); ?></p>
                                <p class="hlm-saat-ini hlm-saat-ini-pal">_</p>
                            </div>
                        </div>
                        <div class="hlm-col-33">
                            <div class="hlm-ltp-item">
                                <p><?php _e( 'Rhodium','calculator-and-display-currency' ); ?></p> 
                                <p class="hlm-saat-ini hlm-saat-ini-rho">_</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hlm-chart-content">
                    <canvas id="hlm-chart-js" height="200px"></canvas>
                </div>
            </div>
        </div>
    </div>
<div>