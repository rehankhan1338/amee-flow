<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    function customCurlAIh($sysInput,$inputText,$maxTokens){
        $sendArrRes = array();
        $CI = & get_instance();
        $apiKey = $CI->config->item('gptApiKey');
        $data = [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                [ "role" => "system", "content" => $sysInput ],
                [ "role" => "user", "content" => $inputText ]
            ],
            'max_tokens' => intval($maxTokens),
            "temperature"=> 0.7
        ];
        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $sendArrRes[] = 'error';
            $sendArrRes[] = curl_error($ch);			
        } else {
            $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($response_code == 200) {
                $response_data = json_decode($response, true);
                $sendArrRes[] = 'success';
                $sendArrRes[] = $response_data;
            } else {
                $sendArrRes[] = 'error';
                $sendArrRes[] = $response;//echo "HTTP request failed! Status code: $response_code\n";
            }
        }		
        curl_close($ch);
        //$sendArrRes[] = 'success';
        //$sendArrRes[] = array();
        return $sendArrRes;
    }

    function formatAIContent($contentChk){
        $contentArr = explode("\n\n", $contentChk);
        $contentArrNew = array();
        foreach ($contentArr as $paragraph) {
            $contentArrNew[] = '<p>' . trim(str_replace('\n','<br>',$paragraph)) . '</p>';
        }
        return implode('',$contentArrNew);
    }        

    function convertToHtmlAvoidAh($response) {
        // Split the response into individual lines
        $lines = explode("\n", $response);
    
        // Initialize variables
        $html_output = '';
        $in_ordered_list = false;
        $in_unordered_list = false;
    
        // Process each line
        foreach ($lines as $line) {
            $line = trim($line);
    
            // Skip empty lines
            if (empty($line)) {
                continue;
            }
    
            // Handle headers (#### or ###, etc.)
            if (preg_match('/^#{4}\s(.+)/', $line, $matches)) {
                // Close any open lists
                if ($in_ordered_list) {
                    $html_output .= "</ol>\n";
                    $in_ordered_list = false;
                }
                if ($in_unordered_list) {
                    $html_output .= "</ul>\n";
                    $in_unordered_list = false;
                }
                $html_output .= "<h4>" . $matches[1] . "</h4>\n";
            } elseif (preg_match('/^#{3}\s(.+)/', $line, $matches)) {
                if ($in_ordered_list) {
                    $html_output .= "</ol>\n";
                    $in_ordered_list = false;
                }
                if ($in_unordered_list) {
                    $html_output .= "</ul>\n";
                    $in_unordered_list = false;
                }
                $html_output .= "<h3>" . $matches[1] . "</h3>\n";
            } elseif (preg_match('/^#{2}\s(.+)/', $line, $matches)) {
                if ($in_ordered_list) {
                    $html_output .= "</ol>\n";
                    $in_ordered_list = false;
                }
                if ($in_unordered_list) {
                    $html_output .= "</ul>\n";
                    $in_unordered_list = false;
                }
                $html_output .= "<h2>" . $matches[1] . "</h2>\n";
            } elseif (preg_match('/^#\s(.+)/', $line, $matches)) {
                if ($in_ordered_list) {
                    $html_output .= "</ol>\n";
                    $in_ordered_list = false;
                }
                if ($in_unordered_list) {
                    $html_output .= "</ul>\n";
                    $in_unordered_list = false;
                }
                $html_output .= "<h1>" . $matches[1] . "</h1>\n";
            }
    
            // Handle bold text (**)
            elseif (preg_match('/\*\*(.*?)\*\*/', $line)) {
                // Close any open lists
                if ($in_ordered_list) {
                    $html_output .= "</ol>\n";
                    $in_ordered_list = false;
                }
                if ($in_unordered_list) {
                    $html_output .= "</ul>\n";
                    $in_unordered_list = false;
                }
                $line = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $line);
                $html_output .= "<p>" . $line . "</p>\n";
            }
    
            // Handle ordered lists (1., 2., 3., etc.)
            elseif (preg_match('/^\d+\.\s(.+)/', $line)) {
                if (!$in_ordered_list) {
                    // Close unordered list if open
                    if ($in_unordered_list) {
                        $html_output .= "</ul>\n";
                        $in_unordered_list = false;
                    }
                    $html_output .= "<ol>\n";
                    $in_ordered_list = true;
                }
                $html_output .= "<li>" . preg_replace('/^\d+\.\s/', '', $line) . "</li>\n";
            }
    
            // Handle unordered lists (-, *, etc.)
            elseif (preg_match('/^[-*]\s(.+)/', $line)) {
                if (!$in_unordered_list) {
                    // Close ordered list if open
                    if ($in_ordered_list) {
                        $html_output .= "</ol>\n";
                        $in_ordered_list = false;
                    }
                    $html_output .= "<ul>\n";
                    $in_unordered_list = true;
                }
                $html_output .= "<li>" . preg_replace('/^[-*]\s/', '', $line) . "</li>\n";
            }
    
            // Handle paragraphs (default case for non-empty lines)
            else {
                // Close any open lists before starting a new paragraph
                if ($in_ordered_list) {
                    $html_output .= "</ol>\n";
                    $in_ordered_list = false;
                }
                if ($in_unordered_list) {
                    $html_output .= "</ul>\n";
                    $in_unordered_list = false;
                }
                $html_output .= "<p>" . $line . "</p>\n";
            }
        }
    
        // Close any open lists at the end
        if ($in_ordered_list) {
            $html_output .= "</ol>\n";
        }
        if ($in_unordered_list) {
            $html_output .= "</ul>\n";
        }
    
        return $html_output;
    }


    function aiApplySampleCode(){
        $this->db->where('promptId', $promptId);
        $query = $this->db->get('prompting');
        $secContent = $query->row_array();

        $catNamesOnly = $userFullName.' categories are '.implode(', ',$catNamesOnlyArr);
        $inputText = str_replace('{allCategories}',$catNamesOnly,$secContent['msgUserRole']);			
        $sysInput = $secContent['msgSystemRole'];
        $maxTokens = $secContent['maxTokenCnt'];

        if(isset($inputText) && $inputText!='' && isset($sysInput) && $sysInput!='' && isset($maxTokens) && $maxTokens!=''){ 
            $resArr = customCurlAIh($sysInput,$inputText,$maxTokens);
            if($resArr[0]=='success'){
                //echo '<pre>';print_r($resArr);die;
                if(isset($resArr[1]['choices'][0]['message']['content']) && $resArr[1]['choices'][0]['message']['content']!=''){
                    $aiContentHere = convertToHtmlAvoidAh($resArr[1]['choices'][0]['message']['content']);
                    $todayDate = strtotime(date('Y-m-d'));						
                    $this->db->insert('self_assessments_competency',array("saId"=>$saId, "userId"=>$userId, "ucId"=>$ucId, "assType"=>$assType, "aiContent"=>$aiContentHere, "catPer"=>$catPer, "assTakenDate"=>$todayDate, "assTakenOn"=>time()));				
                }else{
                    $this->db->insert('api_errors', array("userId"=>$userId, "errorFor"=>$secContent['title'], "errorMsg"=>'No content got from AI Conductor.', "errorOn"=>time()));	
                }
            }
        }else if($resArr[0]=='error'){
            //$errArr[] = array($secContent['title'],$resArr[1]);
            $this->db->insert('api_errors', array("userId"=>$userId, "errorFor"=>$secContent['title'], "errorMsg"=>$resArr[1], "errorOn"=>time()));	
        }
    }
    