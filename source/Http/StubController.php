<?php
// Old and should be removed!
namespace Poing\Earmark\Http;

//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
//use Ylem\Models\Group;
//use Ylem\Models\Stub;
//use Ylem\Models\User;

class StubController extends Controller
{
    public static function stub()
    {
        return 'Earmark';
    }
}
