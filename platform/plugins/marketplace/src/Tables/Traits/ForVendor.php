<?php

namespace Botble\Marketplace\Tables\Traits;

use Botble\Marketplace\Facades\MarketplaceHelper;

trait ForVendor
{
    public function booted(): void
    {
        $this
            ->setView(MarketplaceHelper::viewPath('vendor-dashboard.table.base'))
            ->bulkChangeUrl(route('marketplace.vendor.tables.bulk-change.save'))
            ->bulkChangeDataUrl(route('marketplace.vendor.tables.bulk-change.data'))
            ->bulkActionDispatchUrl(route('marketplace.vendor.tables.bulk-actions.dispatch'))
            ->filterInputUrl(route('marketplace.vendor.tables.get-filter-input'));
    }
}
