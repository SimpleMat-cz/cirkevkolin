<?php

namespace Tests\Feature;

use Tests\TestCase;

class CoDelameTest extends TestCase
{
    public function test_co_delame_index_loads(): void
    {
        $this->get('/co-delame')->assertStatus(200);
    }

    public function test_nedelni_setkani_page_loads(): void
    {
        $this->get('/co-delame/nedelni-setkani')->assertStatus(200);
    }

    public function test_wyldlife_page_loads(): void
    {
        $this->get('/co-delame/wyldlife')->assertStatus(200);
    }

    public function test_kidztown_page_loads(): void
    {
        $this->get('/co-delame/kidztown')->assertStatus(200);
    }

    public function test_skupinky_page_loads(): void
    {
        $this->get('/co-delame/skupinky')->assertStatus(200);
    }
}
