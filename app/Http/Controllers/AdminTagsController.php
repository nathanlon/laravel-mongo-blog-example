<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\TagServiceException;
use App\Services\TagService;

class AdminTagsController
{
    private $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    /**
     * admin_tags_index
     */
    public function index()
    {
        return view(
            'admin.tags.index',
            [
                'tags' => $this->tagService->getAllTags(),
            ]
        );
    }

    /**
     * admin_tag_delete
     */
    public function delete(string $tagId)
    {
        try {
            $this->tagService->deleteTagById($tagId);
        } catch (TagServiceException $e) {
            return redirect(route('admin_tags_index'))->with('error', $e->getMessage());
        }

        return redirect(route('admin_tags_index'))->with('success', 'Tag deleted successfully.');
    }
}
