<?php

namespace App\Http\Controllers;

use App\Models\ClassificationCode;
use Illuminate\Http\Request;

class ClassificationCodeController extends Controller
{
    public function index()
    {
        $classificationCodes = ClassificationCode::all();
        return view('admin.pages.classification_codes.index', compact('classificationCodes'));
    }

    public function create()
    {
        return view('admin.pages.classification_codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ClassificationCode::create($request->all());

        return redirect()->route('classification-codes.index')->with('success', 'Classification Code created successfully.');
    }

    public function edit(ClassificationCode $classificationCode)
    {
        return view('admin.pages.classification_codes.edit', compact('classificationCode'));
    }

    public function update(Request $request, ClassificationCode $classificationCode)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $classificationCode->update($request->all());

        return redirect()->route('classification-codes.index')->with('success', 'Classification Code updated successfully.');
    }

    public function destroy(ClassificationCode $classificationCode)
    {
        $classificationCode->delete();

        return redirect()->route('classification-codes.index')->with('success', 'Classification Code deleted successfully.');
    }
}
