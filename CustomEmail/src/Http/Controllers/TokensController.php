<?php
namespace Leadingdots\CustomEmail\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Leadingdots\CustomEmail\Models\EmailToken;

class TokensController extends Controller {

    /**
     * For showing tokens view
     *
     * @return View responce blade view with data
     */
    public function index(Request $request)
    {
        return view('customemail::tokens.list');
    }

    /**
     * For getting tokens listing
     *
     * @param Request $request request body from client
     * @return Json responce data with http responce code
     */
    public function listTokens(Request $request)
    {
        $query = EmailToken::query();
        $offset = 10;
        if ($request->offset != null && $request->offset != '') {
            $offset = $request->offset;
        }
        
        $items = $query->orderBy('id', 'desc')->paginate($offset);

        $data = [
            'rows' => view('customemail::tokens.list_rows',
                [
                    'items' => $items,
                ]
            )->render(),
            'items' => $items,
            'pagination' => view('customemail::inc.pagination', ['result' => $items])->render(),
        ];
        return response()->json($data, 200);
    }

    /**
     * For showing tokens create view
     *
     * @param Integer $id id of group
     * @return View responce blade with data
     */
    public function create()
    {
        return view('customemail::tokens.add', [
            "item" => false,
        ]);
    }

    /**
     * For updating tokens data
     *
     * @param Request $request request body from client
     * @return Json responce data with http responce code
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|max:25',
            'description' => 'required|max:255',
        ], [
            'token.required' => 'Token is required',
            'description.required' => 'Description is required',
            'token.max' => 'Token should not be more than 25 characters',
            'description.max' => 'Description should not be more than 255 characters',
        ]);

        if ($request->id) {
            $item = EmailToken::find($request->id);
        } else {
            $item = new EmailToken();
        }
        $item->token = $request->token;
        $item->description = $request->description;
        $item->save();
        return response()->json([
            'success' => true,
            'message' => $request->id ? 'Token Updated' : 'Token Added',
            'redirect' => route('ldots.token.index'),
        ]);
    }

    /**
     * For showing tokens edit view
     *
     * @param Integer $id id of group
     * @return View responce blade with data
     */
    public function edit($id)
    {
        return view('customemail::tokens.add', [
            "item" => EmailToken::find($id),
        ]);
    }

    /**
     * For deleting the tokens
     *
     * @param Request $request request body from client
     * @return Json responce data with http responce code
     */
    public function delete(Request $request)
    {
        EmailToken::find($request->id)->delete();
        return response()->json([
            'message' => 'Deleted Successfully!',
        ], 200);
    }

    /**
     * For changing the tokens status
     *
     * @param Request $request request body from client
     * @return Json responce data with http responce code
     */
    public function status(Request $request)
    {
        $item = EmailToken::find($request->id);
        if ($item->status == '1') {
            $item->status = '0';
        } else {
            $item->status = '1';
        }

        $item->save();

        return response()->json([
            'message' => 'Status Changed Successfully',
        ], 200);
    }

}