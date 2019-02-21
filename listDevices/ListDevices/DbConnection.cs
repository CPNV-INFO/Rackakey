using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using MySql.Data.MySqlClient;

namespace ListDevices
{
    class DbConnection
    {
       
        private MySqlConnection connection;

        public DbConnection()
        {
            InitConnection();
        }

        /// <summary>
        /// Add a new usb Key if the key already exist update it
        /// </summary>
        /// <param name="newUsbKey"></param>
        public void AddUsbKey(UsbKey newUsbKey)
        {
            List<UsbKey> usbKeys = new List<UsbKey>();
            bool usbKeyExist = false;

            usbKeys = GetUsbKeys();

            foreach (UsbKey usbKey in usbKeys)
            {
                //if the key already exist update his rack and is port
                if (usbKey.Uuid == newUsbKey.Uuid)
                {
                    MySqlCommand command = this.connection.CreateCommand();

                    command.CommandText = "UPDATE usbs set rack_number = @rack_number, port_number = @port_number, freeSpaceInBytes = @freeSpaceInBytes WHERE uuid = @uuid";

                    command.Parameters.AddWithValue("@uuid", newUsbKey.Uuid);
                    command.Parameters.AddWithValue("@rack_number", newUsbKey.Rack_number);
                    command.Parameters.AddWithValue("@port_number", newUsbKey.Port_number);
                    command.Parameters.AddWithValue("@freeSpaceInBytes", newUsbKey.FreeSpaceInBytes);

                    command.ExecuteNonQuery();

                    usbKeyExist = true;
                }
            }

            //if the usb key dosen't exist we try to add it in the DB
            if (!usbKeyExist)
            {
                try
                {
                    MySqlCommand command = this.connection.CreateCommand(); //create a new request for DB

                    //command for DB
                    command.CommandText = "INSERT INTO usbs (name, uuid, freeSpaceInBytes, status_id, rack_number, port_number, created_at) VALUES (@name, @uuid, @freeSpaceInBytes, @status_id, @rack_number, @port_number, @created_at)";

                    command.Parameters.AddWithValue("@name", newUsbKey.Name);
                    command.Parameters.AddWithValue("@uuid", newUsbKey.Uuid);
                    command.Parameters.AddWithValue("@freeSpaceInBytes", newUsbKey.FreeSpaceInBytes);
                    command.Parameters.AddWithValue("@status_id", newUsbKey.Status_id);
                    command.Parameters.AddWithValue("@rack_number", newUsbKey.Rack_number);
                    command.Parameters.AddWithValue("@port_number", newUsbKey.Port_number);
                    command.Parameters.AddWithValue("@created_at", newUsbKey.Created_at);

                    command.ExecuteNonQuery(); //Execute command
                }
                catch (Exception exc)
                {
                    Console.WriteLine("L'exception suivante est apparue : " + exc);
                }
            }

            
        }

        /// <summary>
        /// Reset the port and hub of every usb keys
        /// </summary>
        public void ResetLocation()
        {
            MySqlCommand command = this.connection.CreateCommand();

            command.CommandText = "UPDATE usbs set rack_number = 0, port_number = 0";

            command.ExecuteNonQuery();
        }

        /// <summary>
        /// Init the connection to MySql DB
        /// </summary>
        private void InitConnection()
        {
            string connection = "SERVER=127.0.0.1; DATABASE=rackakey; UID=root; PASSWORD=";
            this.connection = new MySqlConnection(connection);
            this.connection.Open();
        }

        /// <summary>
        /// Get all usb keys in the usbs table 
        /// </summary>
        /// <returns></returns>
        private List<UsbKey> GetUsbKeys()
        {
            List<UsbKey> usbKeys = new List<UsbKey>();

            try
            {
                MySqlCommand command = this.connection.CreateCommand(); // init a new request to DB

                command.CommandText = "SELECT * FROM usbs"; //request

                MySqlDataReader reader = command.ExecuteReader(); // get all usb in usbs table

                while (reader.Read())
                {
                    UsbKey usbKey = new UsbKey(reader.GetString("name"), reader.GetString("uuid"), reader.GetUInt64("freeSpaceInBytes"), reader.GetString("created_at"), reader.GetInt32("port_number"), reader.GetInt32("rack_number"));
                 
                    usbKeys.Add(usbKey);
                }

                reader.Close();
            }
            catch(Exception exc)
            {
                Console.WriteLine("L'exception suivante est apparue : " + exc);
            }

            return usbKeys;

        }
    }
}
