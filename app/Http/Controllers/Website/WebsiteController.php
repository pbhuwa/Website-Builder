<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Models\Website\Website;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebsiteRequest;
use Illuminate\Support\Facades\Storage;

class WebsiteController extends Controller
{
    /**
     * Display the website list.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $user = auth()->user();
        $websites = Website::where('user_id', $user->id);

        if (request()->has('search')) {
            $search = request()->input('search');
            $websites = $websites->where('name', 'like', "%$search%");
        }
        $websites = $websites->orderBy('created_at', 'desc')->get();

        return response()->json($websites);
    }

    /**
     * Save the website data.
     *
     * @param WebsiteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(WebsiteRequest $request)
    {
        Website::updateOrCreate(
            ['id' => $request->id],
            [
                'user_id' => auth()->user()->id,
                'name' => $request->name,
                'elements' => json_encode($request->elements),
                'canvas_settings' => json_encode($request->canvas)
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Website saved successfully'
        ]);
    }

    /**
     * Load the website data for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function load()
    {
        $user = auth()->user();
        $website = Website::where('user_id', $user->id)->first();

        if (!$website) {
            return response()->json([
                'elements' => [],
                'canvas' => [
                    'width' => 1000,
                    'height' => 2650,
                    'background' => '#ffffff'
                ]
            ]);
        }

        return response()->json([
            'id' => $website->id,
            'name' => $website->name,
            'elements' => json_decode($website->elements, true),
            'canvas' => json_decode($website->canvas_settings, true)
        ]);
    }

    /**
     * Upload an image and return its URL.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $path = $request->file('image')->store('public/images');
        $url = Storage::url($path);

        return response()->json([
            'success' => true,
            'url' => $url
        ]);
    }

    /**
     * Delete a website by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $website = Website::find($id);

        if ($website) {
            $website->delete();
            return response()->json(['success' => true, 'message' => 'Website deleted successfully']);
        }

        return response()->json(['success' => false, 'message' => 'Website not found'], 404);
    }

    /**
     * Get a specific website by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWebsite($id)
    {
        $website = Website::find($id);

        if ($website) {
            return response()->json([
                'id' => $website->id,
                'name' => $website->name,
                'elements' => json_decode($website->elements, true),
                'canvasStyle' => json_decode($website->canvas_settings, true)
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Website not found'], 404);
    }
}
