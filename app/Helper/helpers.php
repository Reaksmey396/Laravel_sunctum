<?php
    function apiResponse($data = null, $status = 0, $smg = ""){
        return response()->json([
            'data' => $data,
            'status' => $status,
            'smg' => $smg
        ]);
    }