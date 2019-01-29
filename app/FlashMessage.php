<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlashMessage extends Model
{
    static public function flash($type, $request, $listOfVars)
    {
        switch ($type) {
            case 'usbAction':
                $request->session()->flash('flashmessage', [
                    "message" =>
                        $listOfVars['usb']->name . ' ' .
                        '(Numéro clé: ' . $listOfVars['usb']->id           . ', ' .
                        'status: '      . $listOfVars['usb']->status->name . ', ' .
                        'Rack: '        . $listOfVars['usb']->rack_number  . ', ' .
                        'Port: '        . $listOfVars['usb']->port_number   . ') a bien été ' . $listOfVars['actionMessage'],
                    "type" =>             $listOfVars['alertType']
                ]);
                break;

            case 'personalized':

                $request->session()->flash('flashmessage', [
                    "message"   => $listOfVars["message"],
                    "type"      => $listOfVars['alertType']
                ]);
                break;
        }
    }
}
