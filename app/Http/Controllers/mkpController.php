<?php
namespace App\Http\Controllers;

use App\Repositories\mkpRepository;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ProfileAddressRequest;
use App\Http\Requests\BusinessRequest;
use App\Http\Requests\BusinessAddressRequest;
use Illuminate\Http\Request;
use Validator;
use Response;

class mkpController extends \App\Http\Controllers\BaseController
{
    protected $redirect = [
        'login' => '/',
        'index' => 'mkp'
    ];

    protected $view = [
        'index' => 'mkp.index',
        'create' => 'mkp.create',
        'edit'  => 'mkp.edit'
    ];

    public function __construct(mkpRepository $mkpRepository)
    {
        parent::__construct();
        $this->messages          = config('message');
        $this->mkpRepository = $mkpRepository;
    }

    /**
     * Method for any index
     */
    public function anyData(Request $request)
    {
        return $this->mkpRepository->getDataMember($request->input());
    }

    /**
     * Method for report excel
     */
    public function report(Request $request)
    {
        $result = $this->mkpRepository->getDataMemberReport($request->input());
        if (!$result) {
            $request->session()->flash('messages', [
                'type' => 'error',
                'text' => 'No Data'
            ]);
            return redirect($this->redirect['index']);
        }
    }

    /**
     * page index
     */
    public function index()
    {
        $stores = $this->mkpRepository->getStoresFilter();

        $current_store = \Session::get('makroStoreId');

        return view($this->view['index'], [
                'stores' => $stores,
                'current_store' => $current_store
            ]
        );
    }

        /**
     * page Create
     */
    public function create()
    {
        $stores = $this->mkpRepository->getStoresFilter();

        $current_store = \Session::get('makroStoreId');

        return view($this->view['create'], [
                'stores' => $stores,
                'current_store' => $current_store
            ]
        );
    }

    /**
     * Method for get update
     */
    public function edit($id, Request $request)
    {
        $result = $this->mkpRepository->getMember($id);

        if (isset($result['data']['records']) && count($result['data']['records']) > 0) {

            //get provinces
            $address = $this->mkpRepository->getAddress($id, $result, 'TH');
            $stores  = $this->mkpRepository->getStores();

            return view($this->view['edit'], [
                'address' => $address,
                'stores'  => $stores,
                'result'  => $result['data']['records'][0]
            ]);

        } else {

            $request->session()->flash('messages', [
                'type' => 'error',
                'text' => $result['errors']['message']
            ]);

            return redirect($this->redirect['index']);

        }
    }

    /**
     * Method for put update
     */
    public function update($id, Request $request, Validator $validator)
    {
        $input = $request->all();

        $rule  = [
            'profile'          => new ProfileRequest(),
            'profile_address'  => new ProfileAddressRequest(),
            'tax'              => new BusinessRequest(),
            'bill'             => new BusinessAddressRequest()
        ];

        if (isset($input['mode']) &&
            ($input['mode'] === 'profile'
                || $input['mode'] === 'profile_address'
                || $input['mode'] === 'tax'
                || $input['mode'] === 'bill'
            )) {

            return $this->updateAll($id, $request, $rule[$input['mode']], $validator);

        } else {
            abort(404);
        }
    }

    /**
     * Method for update my profile or shop profile
     */
    private function updateAll($id, $request, $formRequest, $validator)
    {
        $checkValidator = $validator::make($request->all(), $formRequest->rules(), $formRequest->messages());

        // check error validator
        if ($checkValidator->fails()) {

            $errors   = $checkValidator->messages ();
            $messages = implode("\n", $errors->all());

            return Response::json([
                'status'   => false,
                'messages' => $messages
            ]);

        } else {

            $result = $this->mkpRepository->updateDB($id, $request->input());

            if (isset($result['status']) && $result['status']) {

                $request->session()->flash('messages', [
                    'type' => ($result['status']) ? 'success' : 'error',
                    'text' => $result['messages']
                ]);

                return Response::json(['status' => true]);

            } else {

                return Response::json([
                    'status'   => false,
                    'messages' => $result['messages']
                ]);
            }
        }
    }

    /**
     * Method for post address
     */
    public function address(Request $request)
    {
        $result = [];
        $input  = $request->input();

        if (isset($input['id']) && isset($input['type'])) {

            if ($input['type'] === 'districts') {

                $data = $this->mkpRepository->getDistricts($input['id']);

            } else if ($input['type'] === 'sub_district') {

                $data = $this->mkpRepository->getSubDistricts($input['id']);
            } else if ($input['type'] === 'postcode'){
                $postcode = $this->mkpRepository->getPostcode($input['id']);
                return json_encode($postcode);
            }

            if (count($data) > 0) {
                foreach ($data as $kData => $vData) {
                    $select[] = [
                        'id'   => $kData,
                        'text' => $vData
                    ];
                }

                $result = json_encode($select);
            }
        }

        return $result;
    }

    public function delete(Request $request)
    {
        return Response::json($this->mkpRepository->deleteMember($request->input('id')));
    }
}
?>