<?php


namespace App\Controller\Controller;


use App\Http\NotFoundResponse;
use App\Renderable;

abstract class AbstractRestController extends AbstractController
{
    public function index(): Renderable
    {
        return new NotFoundResponse();
    }

    public function create(): Renderable
    {
        return new NotFoundResponse();
    }

    public function store(): Renderable
    {
        return new NotFoundResponse();
    }

    public function show(string $id): Renderable
    {
        return new NotFoundResponse();
    }

    public function edit(string $id): Renderable
    {
        return new NotFoundResponse();
    }

    public function update(string $id): Renderable
    {
        return new NotFoundResponse();
    }

    public function destroy(string $id): Renderable
    {
        return new NotFoundResponse();
    }
}