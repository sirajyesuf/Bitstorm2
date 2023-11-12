<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Filament\Resources\ProductResource\Widgets\AlertOverview;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Console\View\Components\Info;
use Filament\Forms;
use App\Notifications\ProductDiscountPushNotification;
use App\Models\Product;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Notification as NotificationFacade;
class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;


    protected function getHeaderWidgets(): array
    {
        return [

            AlertOverview::class

        ];
    }



    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Send Discount Alert')
            ->label("🎉 Send Discount Alert")
            ->requiresConfirmation()
            ->form([
                Forms\Components\TextInput::make('discount')
                    ->integer()
                    ->minValue(2)
                    ->default(5)
                    ->label('Discount')
                    ->required()
                    ->suffix('% discount')
                    ->reactive()
                    ->helperText(function(Product $record,$state){
                        return 'New Price of the product will be '.$record->price - ($state /100) * $record->price. ' USD';
                    }),
            ])
            ->action(function (array $data, Product $record): void {


                $record->update([

                    'discount' => $data['discount']
                ]);


                $title = "Special Discount Alert!";
                $body = "Don't miss out on our exclusive discount! Enjoy ". $data['discount']."% off on ". $record->title." Hurry, the offer ends soon!";
                                
                // $record->notify(new ProductDiscountPushNotification($record,$title,$body));

                NotificationFacade::send($record->users, new ProductDiscountPushNotification($record,$title,$body));

                Notification::make()
                ->title('Alert sent successfully')
                ->success()
                ->send();


            })
        ];
    }

    public  function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                Infolists\Components\ImageEntry::make('image')
                ->size(400)
                ->columns(2),
                Infolists\Components\TextEntry::make('title')
                ->columnSpan(2),
                Infolists\Components\TextEntry::make('description')
                ->columnSpan(2),
                Infolists\Components\TextEntry::make('price'),
            ]);
    }
}
