<?php

namespace Botble\Ecommerce\Http\Controllers;

use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Base\Facades\Assets;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Enums\MessageCardTypeEnum;
use Botble\Ecommerce\Forms\MessageCardForm;
use Botble\Ecommerce\Http\Requests\MessageCardRequest;
use Botble\Ecommerce\Models\GroupedMessageCard;
use Botble\Ecommerce\Models\MessageCard;
use Botble\Ecommerce\Models\MessageCardVariation;
use Botble\Ecommerce\Models\MessageCardVariationItem;
use Botble\Ecommerce\Services\MessageCards\DuplicateMessageCardService;
use Botble\Ecommerce\Services\MessageCards\StoreAttributesOfMessageCardService;
use Botble\Ecommerce\Services\MessageCards\StoreMessageCardService;
use Botble\Ecommerce\Services\StoreMessageCardTagService;
use Botble\Ecommerce\Tables\MessageCardTable;
use Botble\Ecommerce\Tables\MessageCardVariationTable;
use Botble\Ecommerce\Traits\MessageCardActionsTrait;
use Illuminate\Http\Request;

class MessageCardController extends BaseController
{
    public function index(MessageCardTable $dataTable)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::message_cards.name'));

        Assets::addScripts(['bootstrap-editable'])
            ->addStyles(['bootstrap-editable']);

        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder, Request $request)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::message_cards.create'));

        return $formBuilder->create(MessageCardForm::class)->renderForm();
    }

    public function edit(MessageCard $message_card, Request $request, FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::message_cards.edit', ['name' => $message_card->title]));

        event(new BeforeEditContentEvent($request, $message_card));

        return $formBuilder
            ->create(MessageCardForm::class, ['model' => $message_card])
            ->renderForm();
    }

    public function store(
        MessageCardRequest $request,
        BaseHttpResponse $response,
    ) {
        $message_card = new MessageCard();

        $message_card->status = $request->input('status');

        $data = $request->input();

        $message_card->fill($data);
        $message_card->save();

        $message_card->categories()->sync($request->input('categories', []));


        return $response
            ->setPreviousUrl(route('message_cards.index'))
            ->setNextUrl(route('message_cards.edit', $message_card->getKey()))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function update(
        MessageCard $message_card,
        MessageCardRequest $request,
        BaseHttpResponse $response,
    ) {
        $message_card->status = $request->input('status');

        $data = $request->input();
        $message_card->fill($data);

        $message_card->save();

        $message_card->categories()->sync($request->input('categories', []));


        MessageCard::query()->update(['status' => $message_card->status]);

        return $response
            ->setPreviousUrl(route('message_cards.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }
}
