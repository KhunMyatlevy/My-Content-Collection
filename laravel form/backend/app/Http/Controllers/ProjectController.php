<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function createProject(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif',
        ]);

        // Get the title, body, and image from the request
        $title = $validated['title'];
        $body = $validated['body'];
        $image = $request->file('image');

        // Generate a new filename for the image and store it in the 'images' folder
        $imageName = time() . '-' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);

        // Prepare the HTML content
        $htmlContent = "
        <!DOCTYPE html>
        <html lang=\"en\">
        <head>
            <meta charset=\"UTF-8\">
            <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
            <title>{$title}</title>
            <link rel=\"stylesheet\" href=\"../css/projects.css\">
        </head>
        <body>

            <div class=\"project\">
                <h2>{$title}</h2>
                <p>{$body}</p>       
                
                <div class=\"project-screenshot\">
                    <img src=\"../images/{$imageName}\" alt=\"{$title}\">
                </div>
            
                <a href=\"../project-list.html\">See More Projects</a>
            </div>
            
        </body>
        </html>";

        // Save the HTML content to a file in the 'projects' folder
        $filePath = public_path("projects/{$title}.html");
        file_put_contents($filePath, $htmlContent);

        // Return a success response
        return response()->json(['success' => true, 'message' => 'Project created successfully']);
    }
}
