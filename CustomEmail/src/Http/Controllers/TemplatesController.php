<?php
namespace Leadingdots\CustomEmail\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Leadingdots\CustomEmail\Models\EmailTemplate;
use Leadingdots\CustomEmail\Models\EmailToken;

class TemplatesController extends Controller {

    /**
     * For showing template view
     *
     * @return View responce blade view with data
     */
    public function index(Request $request)
    {
        return view('customemail::templates.list');
    }

    /**
     * For getting templates listing
     *
     * @param Request $request request body from client
     * @return Json responce data with http responce code
     */
    public function listTemplates(Request $request)
    {
        $query = EmailTemplate::query();
        $offset = 10;
        if ($request->offset != null && $request->offset != '') {
            $offset = $request->offset;
        }
        
        $items = $query->orderBy('id', 'desc')->paginate($offset);

        $data = [
            'rows' => view('customemail::templates.list_rows',
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
     * For showing template create view
     *
     * @param Integer $id id of group
     * @return View responce blade with data
     */
    public function create()
    {
        $tokens = EmailToken::where('status', '1')->get();
        return view('customemail::templates.add', [
            "item" => false,
            "tokens" => $tokens
        ]);
    }

    /**
     * For updating template data
     *
     * @param Request $request request body from client
     * @return Json responce data with http responce code
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'template_name' => 'required|max:50',
            'template_type' => 'required|alpha_dash|max:25|unique:email_template,template_type,' . $request->id . ',id',
            'subject' => 'required|max:255',
            'template' => 'required',
        ], [
            'template_name.required' => 'Name is required',
            'template_type.required' => 'Type is required',
            'subject.required' => 'Subject is required',
            'template.required' => 'Template is required',
            'template_name.max' => 'Name should not be more than 50 characters',
            'template_type.max' => 'Type should not be more than 25 characters',
            'subject.max' => 'Subject should not be more than 255 characters',

            'template_type.alpha_dash' => 'Type should not have any space or special characters',
            'unique.alpha_dash' => 'Type already available please try another type',
        ]);

        if ($request->id) {
            $item = EmailTemplate::find($request->id);
        } else {
            $item = new EmailTemplate();
        }
        $item->template_name = $request->template_name;
        $item->template_type = $request->template_type;
        $item->subject = $request->subject;
        $item->template = $request->template;
        $item->save();
        return response()->json([
            'success' => true,
            'message' => $request->id ? 'Template Updated' : 'Template Added',
            'redirect' => route('ldots.template.index'),
        ]);
    }

    /**
     * For showing template edit view
     *
     * @param Integer $id id of group
     * @return View responce blade with data
     */
    public function edit($id)
    {
        $tokens = EmailToken::where('status', '1')->get();
        return view('customemail::templates.add', [
            "item" => EmailTemplate::find($id),
            "tokens" => $tokens
        ]);
    }

    /**
     * For deleting the template
     *
     * @param Request $request request body from client
     * @return Json responce data with http responce code
     */
    public function delete(Request $request)
    {
        EmailTemplate::find($request->id)->delete();
        return response()->json([
            'message' => 'Deleted Successfully!',
        ], 200);
    }

    /**
     * For changing the template status
     *
     * @param Request $request request body from client
     * @return Json responce data with http responce code
     */
    public function status(Request $request)
    {
        $item = EmailTemplate::find($request->id);
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