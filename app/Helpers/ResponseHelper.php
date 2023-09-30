<?php

    function success($message, $data) {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    function fail($message, $data) {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data
        ]);
    }
